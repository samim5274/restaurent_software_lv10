<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name'        => 'Smart Food Restaurant',
            'address'     => 'Dhaka, Bangladesh',
            'email'       => 'info@smartfood.com',
            'phone'       => '01712345678',
            'website'     => 'https://smartfood.com',
        ]);
    }
}
