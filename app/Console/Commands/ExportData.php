<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Grant;
use App\Models\Project;
use App\Services\Exchange;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:data {--currency=EUR}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        config()->set('money.exportCurrency', $this->option('currency'));

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
            ->map(function (Project $project) {
                $amount = Exchange::convert($project->amount, Exchange::currency(), $project->grant->rate);

                return [
                    'title'             => $project->title,
                    'start_date'        => $project->start_date->toDateString(),
                    'end_date'          => $project->end_date->toDateString(),
                    'amount'            => $amount->toInteger(),
                    'currency'          => $amount->getCurrency(),
                    'grant'             => $project->grant->name,
                    'donors'            => $project->grant->donors->pluck('name')->join('|'),
                    'grantees'          => $project->grantees->pluck('name')->join('|'),
                    'primary_domain'    => $project->grant->primaryDomain->pluck('name')->join('|'),
                    'secondary_domains' => $project->grant->secondaryDomains->pluck('name')->join('|'),
                ];
            });

        $this->export('projects', $projects);
    }

    protected function exportGrants(): void
    {
        $this->info('Exporting grants...');
        $grants = Grant::query()
            ->withTranslation()
            ->get()
            ->map(function (Grant $grant) {
                $amount = Exchange::convert($grant->amount, Exchange::currency(), $grant->rate);

                return [
                    'title'             => $grant->name,
                    'donors'            => $grant->donors->pluck('name')->join('|'),
                    'primary_domain'    => $grant->primaryDomain->pluck('name')->join('|'),
                    'secondary_domains' => $grant->secondaryDomains->pluck('name')->join('|'),
                    'start_date'        => $grant->start_date->toDateString(),
                    'end_date'          => $grant->end_date->toDateString(),
                    'amount'            => $amount->toInteger(),
                    'currency'          => $amount->getCurrency(),
                    'project_count'     => $grant->project_count,
                    'matching'          => boolval($grant->matching),
                    'manager'           => optional($grant->manager)->name,
                    'regranting_amount' => $grant->regranting_amount
                        ? Exchange::convert($grant->regranting_amount, Exchange::currency(), $grant->rate)->toInteger()
                        : null,
                ];
            });

        $this->export('grants', $grants);
    }

    protected function export(string $type, Collection $data)
    {
        $path = storage_path(
            sprintf(
                'app/%s_%s_%s.csv',
                today()->toDateString(),
                $type,
                Exchange::currency()
            )
        );

        $file = fopen($path, 'w');
        fputcsv($file, array_keys($data->first()));

        $data->each(fn ($item) => fputcsv($file, $item));

        fclose($file);

        $this->info(sprintf('Exported %d %s to %s', $data->count(), $type, $path));
    }
}
