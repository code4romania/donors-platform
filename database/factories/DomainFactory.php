<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Domain;
use App\Translations\DomainTranslation;
use Faker\Generator as Faker;

$factory->define(Domain::class, function (Faker $faker) {
    return [];
});

$factory->define(DomainTranslation::class, function (Faker $faker) {
    return [
        'domain_id' => null,
        'name'      => $faker->sentence,
        'locale'    => 'en',
    ];
});

$factory->afterCreating(Domain::class, function (Domain $domain, Faker $faker) {
    $locales = collect(config('translatable.locales'));

    $domain->translation()->saveMany(
        $locales->map(function ($locale) use ($domain) {
            return factory(DomainTranslation::class)
                ->create([
                    'domain_id' => $domain->id,
                    'locale'    => $locale,
                ]);
        })
    );

    // we need to manually "reload" the collection built from the relationship
    // otherwise $this->translations()->get() would NOT be the same as $this->translations
    $domain->load('translations');
});
