<?php

declare(strict_types=1);

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
        factory(User::class)
            ->create([
                'name'  => 'Administrator',
                'email' => 'admin@example.com',
            ])
            ->assignRole('admin');

        factory(User::class, 10)
            ->create()
            ->each
            ->assignRole('user');
    }
}
