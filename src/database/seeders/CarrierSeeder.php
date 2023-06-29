<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Carrier::factory()->createMany([
            [
                'name' => 'Ceva Logistics',
                'delivery_buffer' => 1,
            ],
            [
                'name' => 'UPS',
                'delivery_buffer' => 1,
            ],
            [
                'name' => 'Hepsijet XL',
                'delivery_buffer' => 0,
            ],
            [
                'name' => 'Horoz Lojistik',
                'delivery_buffer' => 2,
            ],
            [
                'name' => 'Yurtiçi Kargo',
                'delivery_buffer' => 1,
            ],
        ]);
    }
}
