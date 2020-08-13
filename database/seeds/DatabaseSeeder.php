<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsSeeder::class);

        $this->call(DemoSeeder::class);

        if (App::environment('local')) {
            // $this->call(UserSeeder::class);
            // $this->call(DomainSeeder::class);
            // $this->call(DonorSeeder::class);
            // $this->call(GrantSeeder::class);
        }
    }
}
