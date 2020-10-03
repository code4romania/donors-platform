<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Grant;
use Illuminate\Console\Command;

class ConvertManagers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:managers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates grant managers relationships';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Grant::has('managers')->each(function (Grant $grant) {
            $grant->grant_manager_id = $grant->managers->first()->id;

            $grant->managers()->sync([]);

            $grant->save();
        });
    }
}
