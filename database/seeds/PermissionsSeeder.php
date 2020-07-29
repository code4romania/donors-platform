<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
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
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage donors']);

        // Create roles and assign existing permissions
        $admin = Role::create(['name' => 'admin']);

        $donor = Role::create(['name' => 'donor'])
            ->givePermissionTo([
                'manage users',
            ]);

        $manager = Role::create(['name' => 'manager'])
            ->givePermissionTo([
                'manage users',
            ]);

        // create a demo user
        $user = factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $user->assignRole($admin);
    }
}
