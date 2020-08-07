<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Grantee;
use Faker\Generator as Faker;

$factory->define(Grantee::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
    ];
});
