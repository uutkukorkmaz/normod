<?php

namespace Database\Factories;

use App\Enums\Statuses\ShippingStatus;
use App\Models\Carrier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pack>
 */
class PackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'carrier_id' => Carrier::inRandomOrder()->first()->id,
            'status' => Lottery::odds(99/100)
                ->loser(fn() => ShippingStatus::Lost)
                ->winner(
                    fn() => $this->faker->randomElement(
                        collect(ShippingStatus::cases())->except(ShippingStatus::Lost->value)
                    )
                )
        ];
    }
}
