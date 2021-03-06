<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Grantee;
use Illuminate\Database\Eloquent\Factories\Factory;

class GranteeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grantee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return  [
            'name' => $this->faker->sentence,
        ];
    }
}
