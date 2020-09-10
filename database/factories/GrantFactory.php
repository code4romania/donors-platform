<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Donor;
use App\Models\Grant;
use App\Translations\GrantTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'name'       => $this->faker->sentence,
            'amount'     => $this->faker->randomFloat(2, 1000),
            'currency'   => $this->faker->randomElement(config('money.currencies.iso')),
            'start_date' => $this->faker->date,
            'end_date'   => $this->faker->date,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Grant $grant) {
            $faker = $this->withFaker();
            $locales = collect(config('translatable.locales'));

            $grant->translation()->saveMany(
                $locales->map(fn ($locale) => GrantTranslation::factory()
                    ->create([
                        'grant_id'  => $grant->id,
                        'locale'    => $locale,
                    ])
                )
            );

            // we need to manually "reload" the collection built from the relationship
            // otherwise $this->translations()->get() would NOT be the same as $this->translations
            $grant->load('translations');

            $grant->donors()->sync(
                Donor::factory()
                    ->count($faker->numberBetween(0, 5))
                    ->create()
            );
        });
    }
}
