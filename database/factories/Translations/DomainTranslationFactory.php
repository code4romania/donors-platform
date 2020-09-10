<?php

declare(strict_types=1);

namespace Database\Factories\Translations;

use App\Translations\DomainTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DomainTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => null,
            'name'      => $this->faker->sentence,
            'locale'    => config('app.locale'),
        ];
    }
}
