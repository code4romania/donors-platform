<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Donor;
use Faker\Generator as Faker;

$factory->define(Donor::class, function (Faker $faker) {
    return [
        'name'    => $faker->company,
        'type'    => $faker->sentence,
        'hq'      => $faker->city,
        'contact' => $faker->name,
        'email'   => $faker->unique()->safeEmail,
        'phone'   => $faker->phoneNumber,
        'areas'   => $faker->words,
    ];
});
