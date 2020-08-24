<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutRebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds the search index for all models';

    /** @var string[] */
    protected $models = [
        \App\Models\Domain::class,
        \App\Models\Donor::class,
        \App\Models\Grant::class,
        \App\Models\Grantee::class,
        \App\Models\GrantManager::class,
        \App\Models\Project::class,
        \App\Models\User::class,
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        collect($this->models)
            ->each(function (string $model): void {
                $this->call('scout:flush', ['model' => $model]);
                $this->call('scout:import', ['model' => $model]);
            });
    }
}
