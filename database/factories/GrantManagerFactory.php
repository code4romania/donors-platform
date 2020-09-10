<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Models\GrantManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GrantManagerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GrantManager::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'         => $this->faker->company,
            'hq'           => $this->faker->city,
            'contact'      => $this->faker->name,
            'email'        => $this->faker->unique()->safeEmail,
            'phone'        => $this->faker->phoneNumber,
            'published_at' => $this->faker->boolean(75) ? Carbon::now() : null,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (GrantManager $manager) {
            $faker = $this->withFaker();

            $manager->domains()->sync(
                Domain::inRandomOrder()->take($faker->numberBetween(0, 3))->get()
            );
        });
    }
}
