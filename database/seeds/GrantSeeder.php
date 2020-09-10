<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Grant;
use Illuminate\Database\Seeder;

class GrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grant::factory()
            ->count(100)
            ->create();
    }
}
