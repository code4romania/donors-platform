<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
            // $this->call(DomainSeeder::class);
            // $this->call(DonorSeeder::class);
            // $this->call(GrantSeeder::class);
            // $this->call(GrantManagerSeeder::class);
            $this->call(UserSeeder::class);
        }
    }
}
