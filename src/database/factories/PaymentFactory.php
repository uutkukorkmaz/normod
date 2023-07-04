<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\Statuses\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'method' => $this->faker->randomElement(PaymentMethod::cases()),
            'status' => Lottery::odds(4 / 10)
                ->loser(fn() => PaymentStatus::Confirmed)
                ->winner(
                    fn() => $this->faker->randomElement(
                        collect(PaymentStatus::cases())->except(PaymentStatus::Confirmed->value)->toArray()
                    )
                ),
            'currency' => config('app.currency'),
        ];
    }

    public function failed()
    {
        return $this->state(fn(array $attributes) => [
            'status' => $this->faker->randomElement(PaymentStatus::failCases())
        ]);
    }
}
