<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->create([
                'name'  => 'Administrator',
                'email' => 'admin@example.com',
            ])
            ->assignRole('admin');

        User::factory()
            ->count(10)
            ->create()
            ->each
            ->assignRole('user');
    }
}
