<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FocusArea;
use App\Translations\FocusAreaTranslation;
use Faker\Generator as Faker;

$factory->define(FocusArea::class, function (Faker $faker) {
    return [];
});

$factory->define(FocusAreaTranslation::class, function (Faker $faker) {
    return [
        'focus_area_id' => null,
        'name'          => $faker->sentence,
        'locale'        => 'en',
    ];
});

$factory->afterCreating(FocusArea::class, function (FocusArea $focusArea, Faker $faker) {
    $locales = collect(config('translatable.locales'));

    $focusArea->translation()->saveMany(
        $locales->map(function ($locale) use ($focusArea) {
            return factory(FocusAreaTranslation::class)
                ->create([
                    'focus_area_id' => $focusArea->id,
                    'locale'        => $locale,
                ]);
        })
    );

    // we need to manually "reload" the collection built from the relationship
    // otherwise $this->translations()->get() would NOT be the same as $this->translations
    $focusArea->load('translations');
});
