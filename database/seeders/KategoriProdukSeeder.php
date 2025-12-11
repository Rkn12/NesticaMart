<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sofas', 'description' => 'Comfortable sofas for your living room'],
            ['name' => 'Tables & Chairs', 'description' => 'Dining tables, coffee tables, and chairs'],
            ['name' => 'Lamps', 'description' => 'Table lamps, floor lamps, and desk lamps'],
            ['name' => 'Beds', 'description' => 'Comfortable beds and mattresses'],
            ['name' => 'Lighting', 'description' => 'Ceiling lights, wall lights, and outdoor lighting'],
            ['name' => 'Cabinets', 'description' => 'Storage cabinets, wardrobes, and bookshelves'],
            ['name' => 'Decorations', 'description' => 'Home decor items to beautify your space'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
