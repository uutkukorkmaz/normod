<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::inRandomOrder()->get()->each(function ($customer) {
            $customer->orders()->saveMany(\App\Models\Order::factory(rand(0, 100) < 60 ? rand(1, 10) : 0)->withCustomerAddress($customer)->make());
        });
    }
}
