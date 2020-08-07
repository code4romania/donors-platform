<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Donor;
use App\Models\FocusArea;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Donor::class, function (Faker $faker) {
    return [
        'name'         => $faker->company,
        'type'         => $faker->sentence,
        'hq'           => $faker->city,
        'contact'      => $faker->name,
        'email'        => $faker->unique()->safeEmail,
        'phone'        => $faker->phoneNumber,
        'published_at' => $faker->boolean(75) ? Carbon::now() : null,
    ];
});

$factory->afterCreating(Donor::class, function (Donor $donor, Faker $faker) {
    $locales = collect(config('translatable.locales'));

    $donor->focusAreas()->sync(
        factory(FocusArea::class, $faker->numberBetween(0, 3))->create()
    );
});
