<?php

declare(strict_types=1);

use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\Project;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loginAsAdmin();

        $this->seedRafData();
    }

    protected function loginAsAdmin()
    {
        $user = User::withRole('admin')->first();

        if ($user) {
            Auth::login($user);
        }
    }

    protected function readData(string $filename): Collection
    {
        $rows = array_map('str_getcsv', file(database_path("demo/{$filename}.csv")));
        $header = array_shift($rows);

        $data = [];
        foreach ($rows as $row) {
            $row = array_combine($header, $row);

            foreach ($row as $key => $value) {
                if (! $value) {
                    $row[$key] = null;
                }

                switch ($key) {
                    case 'start_date':
                    case 'end_date':
                        $row[$key] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
                        break;

                    case 'amount':
                        $row[$key] = intval($value);
                        break;

                    case 'domains':
                        $row[$key] = collect(explode(', ', $value));
                        break;
                }
            }

            $data[] = $row;
        }

        return collect($data);
    }

    protected function seedRafData()
    {
        $donor = Donor::create([
            'name'    => 'Romanian-American Foundation',
            'type'    => 'foundation',
            'hq'      => 'București',
            'contact' => 'Contact Name',
            'email'   => 'office@rafonline.org',
            'phone'   => '+40 312 261 223',
        ]);

        $donor->publish();

        $donor->addMediaFromUrl('https://code4.ro/images/supporters/romanian-american-foundation.png')
            ->toMediaCollection('logo');

        $data = $this->readData('raf');

        $domains = $data->pluck('domains')
            ->flatten()
            ->unique()
            ->filter()
            ->values()
            ->map(fn ($name) => Domain::create(['name' => $name]));

        $grants = $data->pluck('grant')
            ->unique()
            ->filter()
            ->map(function ($name) use ($donor, $domains, $data) {
                $grant = Grant::create([
                    'name'         => $name,
                    'currency'     => 'USD',
                    'published_at' => Carbon::now(),
                ]);

                $grant->domains()->attach(
                    $data->where('grant', $name)
                        ->pluck('domains')
                        ->flatten()
                        ->unique()
                        ->map(fn ($name) => $domains->firstWhere('name', $name)->id ?? null)
                        ->filter()
                );

                $grant->donors()->sync($donor->id);

                return $grant;
            });

        $grantees = $data->pluck('grantee')
            ->unique()
            ->map(fn ($name) => Grantee::create(['name' => $name]));

        $data->each(function ($project) use ($grants, $grantees) {
            if (null === $grant = $grants->firstWhere('name', $project['grant'])) {
                return;
            }

            if (null === $grantee = $grantees->firstWhere('name', $project['grantee'])) {
                return;
            }

            $project = Project::make([
                'title'      => null,
                'amount'     => $project['amount'],
                'currency'   => 'USD',
                'start_date' => $project['start_date'],
                'end_date'   => $project['end_date'],
            ]);

            $project->grant()->associate($grant);
            $project->grantee()->associate($grantee);

            $project->save();
        });

        $grants->each(function ($grant) {
            $grant->amount = $grant->projects
                ->pluck('amount')
                ->filter()
                ->unlessEmpty(
                    fn ($amounts) => Money::sum(...$amounts),
                    fn () => money(0),
                );

            $grant->project_count = $grant->projects->count();

            $grant->save();
        });

        return $data;
    }
}
