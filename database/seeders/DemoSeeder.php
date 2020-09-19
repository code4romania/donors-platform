<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loginAsAdmin();

        $this->call(RafSeeder::class);
    }

    protected function loginAsAdmin()
    {
        $user = User::withRole('admin')->first();

        if ($user) {
            Auth::login($user);
        }
    }
}
