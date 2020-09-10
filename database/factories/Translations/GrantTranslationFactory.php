<?php

declare(strict_types=1);

namespace Database\Factories\Translations;

use App\Translations\GrantTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrantTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GrantTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'grant_id'    => null,
            'name'        => $this->faker->sentence,
            'description' => $this->faker->text,
            'locale'      => config('app.locale'),
        ];
    }
}
