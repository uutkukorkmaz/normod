<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::inRandomOrder()->take(500)->get()->each(function ($customer) {
            $addresses = Address::factory(rand(0, 3))->create(['customer_id' => $customer->id]);
            $addresses->load('customer')
                ->each(function ($address) {
                    echo "\t Created address: " . $address->name . ' for customer: ' . $address->customer->name . PHP_EOL;
                });
        });
    }
}
