<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Champion>
 */
class ChampionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inner_name' => $this->faker->unique()->word(),
            'name' => $this->faker->name(),
            'title' => $this->faker->sentence(3),
            'splash_image' => $this->faker->imageUrl(),
            'square_image' => $this->faker->imageUrl(),
            'patch_version' => '0.0.0',
        ];
    }
}
