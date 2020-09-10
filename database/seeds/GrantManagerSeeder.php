<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GrantManager;
use Illuminate\Database\Seeder;

class GrantManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrantManager::factory()
            ->count(20)
            ->create();
    }
}
