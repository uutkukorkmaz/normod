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
        Customer::all()->each(function ($customer) {
            $addresses = Address::factory(rand(1, 3))->create(['customer_id' => $customer->id]);
        });
    }
}
