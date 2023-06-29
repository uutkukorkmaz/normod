<?php

namespace Database\Factories;

use App\Enums\Statuses\OrderStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => ($customer = Customer::with('addresses')->inRandomOrder()->first())->id,
            'status' => $this->faker->randomElement(OrderStatus::cases()),
            'shipping_address_id' => $customer->addresses->random()->id,
            'billing_address_id' => $customer->addresses->random()->id,
        ];
    }
}
