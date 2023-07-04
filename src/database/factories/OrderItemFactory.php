<?php

namespace Database\Factories;

use App\Enums\Statuses\OrderStatus;
use App\Enums\Statuses\ShippingStatus;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => ($product = Product::inRandomOrder()->first())->id,
            'unit_amount' => $product->price->getAmount(),
            'currency' => $product->currency,
            'quantity' => $this->faker->randomElement(range(1, 5)),
            'status' => OrderStatus::PREPARING
        ];
    }
}
