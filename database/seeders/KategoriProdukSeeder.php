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
            ['name' => 'Fashion', 'description' => 'Pakaian, sepatu, dan aksesoris pria dan wanita'],
            ['name' => 'Buku', 'description' => 'Buku, novel, majalah, dan komik'],
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman'],
            ['name' => 'Kecantikan', 'description' => 'Produk skincare, makeup, dan perawatan tubuh'],
            ['name' => 'Olahraga', 'description' => 'Peralatan dan perlengkapan olahraga'],
            ['name' => 'Rumah Tangga', 'description' => 'Peralatan dan perlengkapan rumah tangga'],
            ['name' => 'Alat Tulis', 'description' => 'Alat tulis dan perlengkapan kantor'],
            ['name' => 'Mainan & Hobi', 'description' => 'Mainan anak dan produk hobi'],
            ['name' => 'Otomotif', 'description' => 'Aksesoris dan suku cadang kendaraan'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
