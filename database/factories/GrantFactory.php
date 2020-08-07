<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use Faker\Generator as Faker;

$factory->define(Grant::class, function (Faker $faker) {
    return [
        'name'       => $faker->sentence,
        'amount'     => $faker->randomFloat(2, 1000),
        'currency'   => $faker->randomElement(config('money.currencies.iso')),
        'start_date' => $faker->date,
        'end_date'   => $faker->date,
    ];
});

$factory->afterCreating(Grant::class, function (Grant $grant, Faker $faker) {
    $grant->donors()->sync(
        factory(Donor::class, $faker->numberBetween(0, 5))->create()
    );

});
