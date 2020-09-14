<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\GrantManager;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RafSeeder extends Seeder
{
    protected Collection $data;

    /**
     * Placeholder domains for feature testing.
     *
     * @var \Illuminate\Support\Collection
     */
    protected Collection $fakeDomains;

    public function __construct()
    {
        $this->fakeDomains = collect([
            'Alt domeniu',
            'Antreprenoriat în educație',
            'Dezvoltare locală',
            'Dezvoltarea locală prin ecoturism',
            'Economie rurală',
            'Educația STEM',
            'Educație civică',
            'Infrastructură civică',
            'Învățământ rural',
            'Tehnologie și inovație',
        ]);

        $this->data = $this->readData();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        $domains = $this->createDomains();
        $grantees = $this->createGrantees();
        $managers = $this->createGrantManagers();

        $this->createGrants($donor, $domains, $grantees, $managers);
    }

    protected function readData(): Collection
    {
        $file = file(database_path('demo/raf.csv'));

        $header = collect(str_getcsv(array_shift($file), ';'))
            ->map(fn ($col) => Str::snake($col));

        return collect($file)
            ->map(
                fn ($row) => $header->combine(str_getcsv($row, ';'))
                    ->map(function ($value, $key) {
                        $value = trim($value);

                        switch (Str::lower($key)) {
                            case 'start_date':
                            case 'end_date':
                                return $value ? Carbon::parse($value)->format('Y-m-d') : null;
                                break;

                            case 're-granted_amount':
                            case 'contracted_in2019':
                            case 'contracted_in2020':
                                return floatval($value);
                                break;

                            case 'domain':
                                // return collect(explode(', ', $value));
                                return $this->fakeDomains->random(
                                    mt_rand(1, 3)
                                );
                                break;

                            case 'grant_manager':
                                return boolval($value);
                                break;

                            default:
                                return $value ?: null;
                                break;
                        }
                    })
            );
    }

    public function createDomains(): Collection
    {
        return $this->data
            ->pluck('domain')
            ->flatten()
            ->unique()
            ->filter()
            ->map(fn ($name) => Domain::create(['name' => $name]));
    }

    public function createGrantees(): Collection
    {
        return $this->data
            ->pluck('grant_beneficiary')
            ->unique()
            ->filter()
            ->map(fn ($name) => Grantee::create(['name' => $name]));
    }

    public function createGrantManagers(): Collection
    {
        return $this->data
            ->where('grant_manager', true)
            ->pluck('grant_beneficiary')
            ->unique()
            ->filter()
            ->map(fn ($name) => GrantManager::create(['name' => $name])->publish());
    }

    public function createGrants(Donor $donor, Collection $domains, Collection $grantees, Collection $managers)
    {
        return $this->data
            ->groupBy('program_name_en')
            ->map(function ($projects, $name) use ($donor, $domains, $grantees, $managers) {
                $grant = Grant::create([
                    'currency'          => 'USD',
                    'amount'            => $projects->pluck('contracted_in2019')->sum(),
                    'project_count'     => $projects->count(),
                    'regranting_amount' => $projects->first()->get('re-granted_amount'),
                    'start_date'        => $projects->first()->get('start_date'),
                    'end_date'          => $projects->first()->get('end_date'),
                    'en'                => [
                        'name'        => $projects->first()->get('program_name_en'),
                        'description' => $projects->first()->get('program_description_en'),
                    ],
                    'ro'                => [
                        'name'        => $projects->first()->get('program_name_ro'),
                        'description' => $projects->first()->get('program_description_ro'),
                    ],
                    'published_at'      => Carbon::now(),
                ]);

                $grant->donors()->sync($donor->id);

                $grant->domains()->sync(
                    $projects
                        ->pluck('domain')
                        ->flatten()
                        ->unique()
                        ->map(fn ($name) => $domains->firstWhere('name', $name)->id ?? null)
                        ->filter()
                );

                if ($projects->first()->get('grant_manager') === true) {
                    $grant->manager()->associate(
                        $managers->firstWhere('name', $projects->first()->get('grant_beneficiary'))->id
                    );
                }

                $grant->save();

                $this->createProjectsForGrant($grant, $projects, $grantees);

                return $grant;
            });
    }

    public function createProjectsForGrant(Grant $grant, Collection $projects, Collection $grantees): Collection
    {
        return $projects->map(function ($data) use ($grant, $grantees) {
            $project = Project::make([
                'title'      => null,
                'amount'     => $data['contracted_in2019'] ?? 0,
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'],
            ]);

            $project->grant()->associate($grant);

            $project->save();

            $project->grantees()->sync(
                $grantees->firstWhere('name', $data['grant_beneficiary'])->id
            );

            return $project;
        });
    }
}
