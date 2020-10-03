<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ConvertRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:roles';

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

            if (! $oldRole) {
                return;
            }

            if ($oldRole->name === 'admin') {
                return $user->update(['role' => 'admin']);
            }

            if ($user->donors->isNotEmpty()) {
                $role = 'donor';
            } elseif ($user->managers->isNotEmpty()) {
                $role = 'manager';
            } else {
                return;
            }

            $user->fill([
                'role' => $role,
            ]);

            $user->organization()->associate(
                $user->{Str::plural($role)}->first()
            );

            $user->save();
        });
    }
}
