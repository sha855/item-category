<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                Item::create([
                    'category_id' => $category->id,
                    'name' => $category->name . " Item $i",
                    'description' => "Description for {$category->name} Item $i",
                    'price' => rand(100, 1000) / 10,
                ]);
            }
        }
    }
}
