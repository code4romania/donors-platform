<?php

declare(strict_types=1);

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
        factory(GrantManager::class, 20)
            ->create();
    }
}
