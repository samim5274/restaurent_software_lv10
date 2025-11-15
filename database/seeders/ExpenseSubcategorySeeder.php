<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;

class ExpenseSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all categories
        $categories = ExpenseCategory::all();

        $subcategories = [
            'Office' => ['Stationery', 'Software', 'Hardware'],
            'Food' => ['Snacks', 'Lunch', 'Beverages'],
            'Travel' => ['Taxi', 'Bus', 'Flight'],
            'Utilities' => ['Electricity', 'Water', 'Internet', 'Gas'],
            'Maintenance' => ['Plumbing', 'Electrical', 'Cleaning'],
        ];

        foreach ($categories as $category) {
            if(isset($subcategories[$category->name])) {
                foreach ($subcategories[$category->name] as $sub) {
                    ExpenseSubcategory::create([
                        'category_id' => $category->id,
                        'name' => $sub,
                        'description' => $sub . ' expense under ' . $category->name,
                    ]);
                }
            }
        }
    }
}
