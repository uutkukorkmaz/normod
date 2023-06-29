<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(0, 100, pow(100,3)),
            'cost' => $this->faker->randomFloat(0, 100, pow(100,2)),
            'currency' => $this->faker->randomElement(array_keys(config('currency'))),
            'production_buffer' => $this->faker->numberBetween(1, 5),
        ];
    }
}
