<?php

namespace Database\Seeders;

use App\Enums\Statuses\OrderStatus;
use App\Models\Order;
use App\Models\Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::whereIn('status', [
            OrderStatus::PREPARING,
            OrderStatus::SHIPPED_OUT,
            OrderStatus::DELIVERED,
            OrderStatus::RETURNED
        ])->get()->each(function ($order) {
            $packGroup = [];
            $items = $order->items();
            $itemCount = $items->count();
            $items->get()->each(function ($item) use (&$packGroup, $itemCount) {
                $packGroup[rand(0, $itemCount - 1)][] = $item;
            });


            collect($packGroup)->each(function ($packItems) use($order) {
                $pack = Pack::factory()->create([
                    'order_id' => $order->id
                ]);
                foreach($packItems as $packItem){
                    $packItem->pack()->associate($pack);
                }
            });
        });
    }
}
