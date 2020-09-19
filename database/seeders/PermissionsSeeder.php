<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    protected array $roles = [
        'admin', 'user',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Create roles
        collect($this->roles)
            ->each(fn ($role) => app(config('permission.models.role'))->create(['name' => $role]));

        // Create permissions
        collect(config('permission.app.models'))
            ->crossJoin(config('permission.app.actions'))
            ->mapSpread(fn ($model, $action) => "$model.$action")
            ->each(fn ($permission) => app(config('permission.models.permission'))::create(['name' => $permission]));
    }
}
