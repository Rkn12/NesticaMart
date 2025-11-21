<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = Seller::where('status', 'approved')->get();
        
        if ($sellers->isEmpty()) {
            $this->command->warn('Tidak ada seller approved');
            return;
        }

        $categories = \App\Models\ProductCategory::all();

        // Produk untuk Toko Elektronik Jakarta (seller_id: 1)
        Product::create([
            'seller_id' => 1,
            'category_id' => $categories->where('name', 'Elektronik')->first()->id,
            'name' => 'Laptop ASUS VivoBook 14',
            'description' => 'Laptop ringan dengan prosesor Intel Core i5 Gen 11, RAM 8GB, SSD 512GB, layar 14 inch Full HD',
            'price' => 7500000,
            'stock' => 15,
            'sold_count' => 234,
            'weight' => 1500,
            'condition' => 'new',
            'location_province' => 'DKI Jakarta',
            'location_city' => 'Jakarta Pusat',
        ]);

        Product::create([
            'seller_id' => 1,
            'category_id' => $categories->where('name', 'Elektronik')->first()->id,
            'name' => 'Mouse Wireless Logitech M331',
            'description' => 'Mouse wireless ergonomis dengan baterai tahan hingga 24 bulan, cocok untuk kerja dan gaming casual',
            'price' => 125000,
            'stock' => 50,
            'sold_count' => 1250,
            'weight' => 100,
            'condition' => 'new',
            'location_province' => 'DKI Jakarta',
            'location_city' => 'Jakarta Pusat',
        ]);

        Product::create([
            'seller_id' => 1,
            'category_id' => $categories->where('name', 'Elektronik')->first()->id,
            'name' => 'Keyboard Mechanical Keychron K2',
            'description' => 'Keyboard mechanical 75% layout dengan switch Gateron Brown, koneksi wireless & kabel',
            'price' => 950000,
            'stock' => 20,
            'sold_count' => 458,
            'weight' => 600,
            'condition' => 'new',
            'location_province' => 'DKI Jakarta',
            'location_city' => 'Jakarta Pusat',
        ]);

        // Produk untuk Toko Buku Surabaya (seller_id: 2)
        Product::create([
            'seller_id' => 2,
            'category_id' => $categories->where('name', 'Buku')->first()->id,
            'name' => 'Buku The Psychology of Money',
            'description' => 'Buku best seller tentang psikologi keuangan dan investasi oleh Morgan Housel, edisi bahasa Indonesia',
            'price' => 95000,
            'stock' => 100,
            'sold_count' => 3200,
            'weight' => 300,
            'condition' => 'new',
            'location_province' => 'Jawa Timur',
            'location_city' => 'Surabaya',
        ]);

        Product::create([
            'seller_id' => 2,
            'category_id' => $categories->where('name', 'Buku')->first()->id,
            'name' => 'Novel Laskar Pelangi - Andrea Hirata',
            'description' => 'Novel best seller Indonesia tentang perjuangan anak-anak Belitung menuntut ilmu',
            'price' => 75000,
            'stock' => 80,
            'sold_count' => 5400,
            'weight' => 400,
            'condition' => 'new',
            'location_province' => 'Jawa Timur',
            'location_city' => 'Surabaya',
        ]);

        Product::create([
            'seller_id' => 2,
            'category_id' => $categories->where('name', 'Buku')->first()->id,
            'name' => 'Buku Atomic Habits - James Clear',
            'description' => 'Panduan praktis membangun kebiasaan baik dan menghilangkan kebiasaan buruk',
            'price' => 110000,
            'stock' => 60,
            'sold_count' => 2800,
            'weight' => 350,
            'condition' => 'new',
            'location_province' => 'Jawa Timur',
            'location_city' => 'Surabaya',
        ]);

        // Produk untuk Fashion Store Bandung (seller_id: 3)
        Product::create([
            'seller_id' => 3,
            'category_id' => $categories->where('name', 'Fashion')->first()->id,
            'name' => 'Kemeja Pria Lengan Panjang Formal',
            'description' => 'Kemeja formal premium katun stretch, nyaman dipakai seharian, tersedia ukuran M-XXL',
            'price' => 185000,
            'stock' => 45,
            'sold_count' => 892,
            'weight' => 250,
            'condition' => 'new',
            'location_province' => 'Jawa Barat',
            'location_city' => 'Bandung',
        ]);

        Product::create([
            'seller_id' => 3,
            'category_id' => $categories->where('name', 'Fashion')->first()->id,
            'name' => 'Dress Wanita Casual Motif Floral',
            'description' => 'Dress casual dengan bahan katun rayon adem, cocok untuk hangout dan acara santai',
            'price' => 165000,
            'stock' => 35,
            'sold_count' => 1567,
            'weight' => 200,
            'condition' => 'new',
            'location_province' => 'Jawa Barat',
            'location_city' => 'Bandung',
        ]);

        Product::create([
            'seller_id' => 3,
            'category_id' => $categories->where('name', 'Fashion')->first()->id,
            'name' => 'Jaket Hoodie Unisex Polos',
            'description' => 'Jaket hoodie fleece tebal dan hangat, tersedia banyak warna, cocok untuk pria dan wanita',
            'price' => 145000,
            'stock' => 70,
            'sold_count' => 2340,
            'weight' => 400,
            'condition' => 'new',
            'location_province' => 'Jawa Barat',
            'location_city' => 'Bandung',
        ]);

        // Produk untuk Toko Alat Olahraga Jogja (seller_id: 4)
        Product::create([
            'seller_id' => 4,
            'category_id' => $categories->where('name', 'Olahraga')->first()->id,
            'name' => 'Raket Badminton Yonex Astrox 88D',
            'description' => 'Raket badminton profesional untuk smash power, cocok untuk pemain tingkat menengah ke atas',
            'price' => 1850000,
            'stock' => 12,
            'sold_count' => 156,
            'weight' => 500,
            'condition' => 'new',
            'location_province' => 'DI Yogyakarta',
            'location_city' => 'Yogyakarta',
        ]);

        Product::create([
            'seller_id' => 4,
            'category_id' => $categories->where('name', 'Olahraga')->first()->id,
            'name' => 'Sepatu Futsal Nike Mercurial',
            'description' => 'Sepatu futsal dengan sol karet anti-slip, nyaman untuk permainan cepat dan lincah',
            'price' => 650000,
            'stock' => 25,
            'sold_count' => 743,
            'weight' => 700,
            'condition' => 'new',
            'location_province' => 'DI Yogyakarta',
            'location_city' => 'Yogyakarta',
        ]);

        Product::create([
            'seller_id' => 4,
            'category_id' => $categories->where('name', 'Olahraga')->first()->id,
            'name' => 'Dumbbell Set 10kg (2x5kg)',
            'description' => 'Set dumbbell besi dengan lapisan karet, cocok untuk home workout dan fitness',
            'price' => 250000,
            'stock' => 30,
            'sold_count' => 1890,
            'weight' => 10000,
            'condition' => 'new',
            'location_province' => 'DI Yogyakarta',
            'location_city' => 'Yogyakarta',
        ]);

        // Produk untuk Toko Kosmetik Bali (seller_id: 5)
        Product::create([
            'seller_id' => 5,
            'category_id' => $categories->where('name', 'Kecantikan')->first()->id,
            'name' => 'Wardah Lightening Face Serum',
            'description' => 'Serum wajah dengan vitamin C untuk mencerahkan dan meratakan warna kulit',
            'price' => 45000,
            'stock' => 100,
            'sold_count' => 4560,
            'weight' => 50,
            'condition' => 'new',
            'location_province' => 'Bali',
            'location_city' => 'Denpasar',
        ]);

        Product::create([
            'seller_id' => 5,
            'category_id' => $categories->where('name', 'Kecantikan')->first()->id,
            'name' => 'Emina Bright Stuff Moisturizing Cream',
            'description' => 'Pelembab wajah ringan dengan SPF 15, cocok untuk kulit remaja dan berminyak',
            'price' => 32000,
            'stock' => 120,
            'sold_count' => 6780,
            'weight' => 100,
            'condition' => 'new',
            'location_province' => 'Bali',
            'location_city' => 'Denpasar',
        ]);

        Product::create([
            'seller_id' => 5,
            'category_id' => $categories->where('name', 'Kecantikan')->first()->id,
            'name' => 'Somethinc Niacinamide Acne Serum',
            'description' => 'Serum untuk mengatasi jerawat dengan niacinamide 10% dan zinc, aman untuk kulit sensitif',
            'price' => 89000,
            'stock' => 85,
            'sold_count' => 3450,
            'weight' => 60,
            'condition' => 'new',
            'location_province' => 'Bali',
            'location_city' => 'Denpasar',
        ]);
    }
}
