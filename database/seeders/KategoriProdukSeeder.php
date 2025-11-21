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
            ['name' => 'Elektronik', 'description' => 'Peralatan elektronik seperti smartphone, laptop, TV, dan aksesoris'],
            ['name' => 'Fashion Pria', 'description' => 'Pakaian, sepatu, dan aksesoris untuk pria'],
            ['name' => 'Fashion Wanita', 'description' => 'Pakaian, sepatu, dan aksesoris untuk wanita'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Kesehatan & Kecantikan', 'description' => 'Produk kesehatan dan kecantikan'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga'],
            ['name' => 'Rumah Tangga', 'description' => 'Peralatan dan perlengkapan rumah tangga'],
            ['name' => 'Buku & Alat Tulis', 'description' => 'Buku, majalah, dan alat tulis'],
            ['name' => 'Mainan & Hobi', 'description' => 'Mainan anak dan produk hobi'],
            ['name' => 'Otomotif', 'description' => 'Aksesoris dan suku cadang kendaraan'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
