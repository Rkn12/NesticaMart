<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('Tidak ada produk. Jalankan ProductSeeder terlebih dahulu.');
            return;
        }

        // Review for Product 1: Modern Grey Sectional Sofa
        ProductReview::create([
            'product_id' => 1,
            'reviewer_name' => 'Ahmad Fauzi',
            'reviewer_phone' => '081234567891',
            'reviewer_email' => 'ahmad.fauzi@gmail.com',
            'reviewer_province' => 'DKI Jakarta',
            'rating' => 5,
            'comment' => 'Sofa sangat nyaman dan empuk. Warna abunya pas banget sama interior ruang tamu saya. Pengiriman juga cepat.',
        ]);

        ProductReview::create([
            'product_id' => 1,
            'reviewer_name' => 'Siti Nurhaliza',
            'reviewer_phone' => '082345678902',
            'reviewer_email' => 'siti.nur@yahoo.com',
            'reviewer_province' => 'Jawa Barat',
            'rating' => 4,
            'comment' => 'Kualitas kain bagus, tidak panas. Cuma perakitannya butuh waktu sedikit lama. Overall puas!',
        ]);

        // Review for Product 2: Minimalist TV Console
        ProductReview::create([
            'product_id' => 2,
            'reviewer_name' => 'Budi Santoso',
            'reviewer_phone' => '083456789013',
            'reviewer_email' => 'budi.s@outlook.com',
            'reviewer_province' => 'Jawa Barat',
            'rating' => 5,
            'comment' => 'Desain minimalis modern, cocok buat TV 50 inch. Laci penyimpanannya juga luas.',
        ]);

        // Review for Product 3: Queen Size Upholstered Bed Frame
        ProductReview::create([
            'product_id' => 3,
            'reviewer_name' => 'Dian Kusuma',
            'reviewer_phone' => '084567890124',
            'reviewer_email' => 'dian.k@gmail.com',
            'reviewer_province' => 'Jawa Tengah',
            'rating' => 5,
            'comment' => 'Rangka tempat tidur kokoh, headboard-nya mewah banget. Tidur jadi makin nyenyak.',
        ]);

        ProductReview::create([
            'product_id' => 3,
            'reviewer_name' => 'Eko Prasetyo',
            'reviewer_phone' => '085678901235',
            'reviewer_email' => 'eko.p@gmail.com',
            'reviewer_province' => 'DI Yogyakarta',
            'rating' => 4,
            'comment' => 'Barang bagus, sesuai deskripsi. Pengiriman agak telat dikit tapi seller responsif.',
        ]);

        // Review for Product 4: Set of 3 Abstract Canvas Prints
        ProductReview::create([
            'product_id' => 4,
            'reviewer_name' => 'Rina Wijaya',
            'reviewer_phone' => '086789012346',
            'reviewer_email' => 'rina.w@yahoo.com',
            'reviewer_province' => 'Bali',
            'rating' => 5,
            'comment' => 'Lukisannya cantik banget! Bikin suasana kamar jadi lebih hidup. Kualitas cetakan tajam.',
        ]);

        // Review for Product 5: Teak Wood Dining Table
        ProductReview::create([
            'product_id' => 5,
            'reviewer_name' => 'Teguh Prasetyo',
            'reviewer_phone' => '087890123457',
            'reviewer_email' => 'teguh.p@gmail.com',
            'reviewer_province' => 'Sumatera Utara',
            'rating' => 5,
            'comment' => 'Meja jati asli, berat dan kokoh. Finishing halusnya juara. Worth every penny!',
        ]);

        // Review for Product 6: Rustic Wooden Dining Chair
        ProductReview::create([
            'product_id' => 6,
            'reviewer_name' => 'Indah Permata',
            'reviewer_phone' => '088901234568',
            'reviewer_email' => 'indah.p@gmail.com',
            'reviewer_province' => 'Jawa Timur',
            'rating' => 5,
            'comment' => 'Kursinya nyaman diduduki, sandarannya pas di punggung. Serasi banget sama mejanya.',
        ]);

        // Review for Product 7: Industrial Floor Lamp
        ProductReview::create([
            'product_id' => 7,
            'reviewer_name' => 'Joko Susilo',
            'reviewer_phone' => '089012345679',
            'reviewer_email' => 'joko.s@outlook.com',
            'reviewer_province' => 'DKI Jakarta',
            'rating' => 4,
            'comment' => 'Lampu estetik, cocok buat baca buku. Sayang bohlamnya harus beli terpisah.',
        ]);

        // Review for Product 8: Modern Pendant Light
        ProductReview::create([
            'product_id' => 8,
            'reviewer_name' => 'Kartika Sari',
            'reviewer_phone' => '080123456780',
            'reviewer_email' => 'kartika.s@gmail.com',
            'reviewer_province' => 'Jawa Barat',
            'rating' => 5,
            'comment' => 'Lampu gantungnya elegan, bikin ruang makan jadi mewah. Pemasangan juga mudah.',
        ]);

        // Review for Product 9: Rattan Lounge Chair
        ProductReview::create([
            'product_id' => 9,
            'reviewer_name' => 'Lestari Putri',
            'reviewer_phone' => '081234567892',
            'reviewer_email' => 'lestari.p@yahoo.com',
            'reviewer_province' => 'Bali',
            'rating' => 5,
            'comment' => 'Kursi rotan ternyaman yang pernah saya beli. Buat santai sore di teras enak banget.',
        ]);

        // Update average rating untuk semua produk
        $products->each(function ($product) {
            $averageRating = $product->reviews()->avg('rating');
            if ($averageRating) {
                $product->update(['average_rating' => round($averageRating, 2)]);
            }
        });
    }
}
