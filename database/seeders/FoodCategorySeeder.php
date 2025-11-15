<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\FoodCategory;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Burgers',
            'Pizza',
            'Sandwiches',
            'Pasta',
            'Salads',
            'Desserts',
            'Beverages',
            'Seafood',
            'Grill',
            'Breakfast',
        ];

        foreach ($categories as $category) {
            FoodCategory::create([
                'name' => $category
            ]);
        }
    }
}
