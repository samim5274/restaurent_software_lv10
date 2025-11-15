<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['name' => 'Cash', 'status' => 1],
            ['name' => 'Bkash', 'status' => 1],
            ['name' => 'Nagad', 'status' => 1],
            ['name' => 'Rocket', 'status' => 1],
            ['name' => 'Card', 'status' => 1],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
