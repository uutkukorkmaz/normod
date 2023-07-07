<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $customer = \App\Models\Customer::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => Hash::make($password = 'password'),
         ]);

        $this->call(CustomerSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(PackSeeder::class);
        $this->call(PaymentSeeder::class);

        dump(['TEST_CUSTOMER' => $customer->only('email') + ['password' => $password]]);
    }
}
