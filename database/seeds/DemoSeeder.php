<?php

declare(strict_types=1);

use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedRafData();
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
                        $row[$key] = $value ? Carbon\Carbon::parse($value)->format('Y-m-d') : null;
                        break;

                    case 'amount':
                        $row[$key] = intval($value);
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
            'name' => 'RAF',
            'type' => '',
            'hq'   => 'București',
        ]);

        $donor->publish();

        $donor->addMediaFromUrl('https://code4.ro/images/supporters/romanian-american-foundation.png')
            ->toMediaCollection('logo');

        $data = $this->readData('raf');

        $data->pluck('grant')
            ->unique()
            ->filter()
            ->each(function ($grantName) use ($donor) {
                $grant = Grant::firstOrCreate([
                    'name'     => $grantName,
                    'currency' => 'USD',
                ]);

                $grant->donors()->sync($donor->id);
            });

        $data->each(function ($project) {
            $domain = Domain::whereTranslation('name', $project['domain'])->first()
                ?? Domain::create(['name' => $project['domain']]);

            $grantee = Grantee::firstOrCreate(['name' => $project['grantee']]);

            if (is_null($project['grant'])) {
                return;
            }

            $grant = Grant::firstWhere('name', $project['grant']);

            $grant->domain()->associate($domain)->save();

            $grant->grantees()->attach([
                $grantee->id => [
                    'title'      => $project['title'],
                    'amount'     => $project['amount'],
                    'currency'   => 'USD',
                    'start_date' => $project['start_date'],
                    'end_date'   => $project['end_date'],
                ],
            ]);
        });

        return $data;
    }
}
