<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'name' => $this->faker->name.'\'s Home',
            'address_line_one' => $this->faker->streetAddress,
            'address_line_two' => null,
            'city' => $this->faker->city,
            'state' => $this->faker->country,
            'zip_code' => $this->faker->postcode,
        ];
    }
}
