<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates old role system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::all()->each(function (User $user) {
            $oldRole = $user->roles->first();

            if ($oldRole->name === 'admin') {
                return $user->update(['role' => 'admin']);
            }

            if (! $user->donors->isEmpty()) {
                return $user->update([
                    'role'            => 'donor',
                    'organization_id' => $user->donors->first()->id,
                ]);
            }

            if (! $user->managers->isEmpty()) {
                return $user->update([
                    'role' => 'manager',
                    'organization_id' => $user->managers->first()->id,
                ]);
            }
        });
    }
}
