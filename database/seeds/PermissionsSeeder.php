<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    protected array $permissions = [
        'admin' => [
            'view users',
            'manage users',
        ],
        'user' => [
            //
        ],
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

        // Create permissions
        collect($this->permissions)
            ->flatten()
            ->unique()
            ->each(fn ($permission) => Permission::create(['name' => $permission]));

        // Create roles and assign existing permissions
        collect($this->permissions)
            ->each(function ($permissions, $role) {
                Role::create(['name' => $role])
                    ->givePermissionTo($permissions);
            });
    }
}
