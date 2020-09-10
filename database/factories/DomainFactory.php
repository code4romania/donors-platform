<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Translations\DomainTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Domain $domain) {
            $locales = collect(config('translatable.locales'));

            $domain->translation()->saveMany(
                $locales->map(fn ($locale) => DomainTranslation::factory()
                    ->create([
                        'domain_id' => $domain->id,
                        'locale'    => $locale,
                    ])
                )
            );

            // we need to manually "reload" the collection built from the relationship
            // otherwise $this->translations()->get() would NOT be the same as $this->translations
            $domain->load('translations');
        });
    }
}
