<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Grant;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->exportProjects();

        $this->exportGrants();

        return 0;
    }

    protected function exportProjects(): void
    {
        $this->info('Exporting projects...');

        $projects = Project::query()
            ->with('grant.donors', 'grant.primaryDomain', 'grant.secondaryDomains', 'grantees')
            ->get()
            ->map(fn (Project $project) => [
                'title'             => $project->title,
                'start_date'        => $project->start_date->toDateString(),
                'end_date'          => $project->end_date->toDateString(),
                'amount'            => $project->amount->toInteger(),
                'currency'          => $project->currency,
                'grant'             => $project->grant->name,
                'donors'            => $project->grant->donors->pluck('name')->join('|'),
                'grantees'          => $project->grantees->pluck('name')->join('|'),
                'primary_domain'    => $project->grant->primaryDomain->pluck('name')->join('|'),
                'secondary_domains' => $project->grant->secondaryDomains->pluck('name')->join('|'),
            ]);

        $this->export('projects', $projects);
    }

    protected function exportGrants(): void
    {
        $this->info('Exporting grants...');
        $grants = Grant::query()
            ->withTranslation()
            ->get()
            ->map(fn (Grant $grant) => [
                'title'             => $grant->name,
                'start_date'        => $grant->start_date->toDateString(),
                'end_date'          => $grant->end_date->toDateString(),
                'amount'            => $grant->amount->toInteger(),
                'currency'          => $grant->currency,
                'project_count'     => $grant->project_count,
                'matching'          => boolval($grant->matching),
                'manager'           => optional($grant->manager)->name,
                'regranting_amount' => optional($grant->regranting_amount)->toInteger(),
            ]);

        $this->export('grants', $grants);
    }

    protected function export(string $type, Collection $data)
    {
        $path = storage_path(sprintf('app/%s_%s.csv', today()->toDateString(), $type));

        $file = fopen($path, 'w');
        fputcsv($file, array_keys($data->first()));

        $data->each(fn ($item) => fputcsv($file, $item));

        fclose($file);

        $this->info(sprintf('Exported %d %s to %s', $data->count(), $type, $path));
    }
}
