<?php

declare(strict_types=1);

use App\Models\Grantee;
use Illuminate\Database\Seeder;

class GranteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Grantee::class, 100)
            ->create();
    }
}
