<?php

namespace Database\Seeders;

use App\Enums\Statuses\OrderStatus;
use App\Enums\Statuses\PaymentStatus;
use App\Models\Payment;
use App\Repositories\Contracts\OrderRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Lottery;

class PaymentSeeder extends Seeder
{

    protected $orderStatusesToMap = [
        OrderStatus::CANCELLED,
        OrderStatus::PAYMENT_PENDING,
        OrderStatus::RETURNED
    ];

    protected $statusMap = [
        [PaymentStatus::Cancelled],
        [PaymentStatus::Pending],
        [PaymentStatus::Refunded, PaymentStatus::RefundPending]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = collect($this->orderStatusesToMap)->mapWithKeys(function($val,$key){
            $str = $val->value;
           return [
               $str => $this->statusMap[$key]
           ];
        })->toArray();


        app(OrderRepository::class)->onlyPaid()
            ->each(function ($order) use($map) {
                if ($order->payments()->count()) {
                    return;
                }

                Lottery::odds(3 / 10)->winner(function () use ($order) {
                    $order->payments()->saveMany(Payment::factory(rand(1, 4))->failed()->make());
                });

                $order->payments()->save(
                    Payment::factory()->make([
                        'status' => collect($map[$order->status->value] ?? [PaymentStatus::Confirmed])->shuffle()->first(),
                        'total_amount' => app(OrderRepository::class)->getTotalAmount($order)
                    ])
                );
            });
    }
}
