<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Domain;
use App\Models\GrantManager;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(GrantManager::class, function (Faker $faker) {
    return [
        'name'         => $faker->company,
        'hq'           => $faker->city,
        'contact'      => $faker->name,
        'email'        => $faker->unique()->safeEmail,
        'phone'        => $faker->phoneNumber,
        'published_at' => $faker->boolean(75) ? Carbon::now() : null,
    ];
});

$factory->afterCreating(GrantManager::class, function (GrantManager $manager, Faker $faker) {
    $manager->domains()->sync(
        // factory(Domain::class, $faker->numberBetween(0, 3))->create()
        Domain::inRandomOrder()->take($faker->numberBetween(0, 3))->get()
    );
});
