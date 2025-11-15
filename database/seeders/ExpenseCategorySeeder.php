<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Office', 'description' => 'Office related expenses'],
            ['name' => 'Food', 'description' => 'Food & Beverages'],
            ['name' => 'Travel', 'description' => 'Travel and transportation'],
            ['name' => 'Utilities', 'description' => 'Electricity, Water, Internet, etc.'],
            ['name' => 'Maintenance', 'description' => 'Repairs & maintenance'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
