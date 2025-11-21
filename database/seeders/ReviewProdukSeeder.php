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

        // Review untuk Laptop ASUS VivoBook 14
        ProductReview::create([
            'product_id' => 1,
            'reviewer_name' => 'Ahmad Fauzi',
            'reviewer_phone' => '081234567891',
            'reviewer_email' => 'ahmad.fauzi@gmail.com',
            'reviewer_province' => 'DKI Jakarta',
            'rating' => 5,
            'comment' => 'Laptop sangat responsif, cocok untuk kerja dan coding. Pengiriman cepat, packing rapi!',
        ]);

        ProductReview::create([
            'product_id' => 1,
            'reviewer_name' => 'Siti Nurhaliza',
            'reviewer_phone' => '082345678902',
            'reviewer_email' => 'siti.nur@yahoo.com',
            'reviewer_province' => 'Jawa Barat',
            'rating' => 4,
            'comment' => 'Bagus sih, tapi agak berat untuk dibawa-bawa. Overall puas!',
        ]);

        // Review untuk Mouse Wireless Logitech
        ProductReview::create([
            'product_id' => 2,
            'reviewer_name' => 'Budi Santoso',
            'reviewer_phone' => '083456789013',
            'reviewer_email' => 'budi.s@outlook.com',
            'reviewer_province' => 'Jawa Timur',
            'rating' => 5,
            'comment' => 'Mouse enak dipake, wireless stabil, baterai awet. Recommended!',
        ]);

        // Review untuk Keyboard Mechanical
        ProductReview::create([
            'product_id' => 3,
            'reviewer_name' => 'Dian Kusuma',
            'reviewer_phone' => '084567890124',
            'reviewer_email' => 'dian.k@gmail.com',
            'reviewer_province' => 'Jawa Tengah',
            'rating' => 5,
            'comment' => 'Keyboard mantap! Switch Gateron Brown-nya enak buat ngetik lama. Koneksi wireless lancar jaya.',
        ]);

        ProductReview::create([
            'product_id' => 3,
            'reviewer_name' => 'Eko Prasetyo',
            'reviewer_phone' => '085678901235',
            'reviewer_email' => 'eko.p@gmail.com',
            'reviewer_province' => 'DI Yogyakarta',
            'rating' => 4,
            'comment' => 'Kualitas build solid, tapi harganya agak mahal. Tapi worth it sih!',
        ]);

        // Review untuk Buku Psychology of Money
        ProductReview::create([
            'product_id' => 4,
            'reviewer_name' => 'Rina Wijaya',
            'reviewer_phone' => '086789012346',
            'reviewer_email' => 'rina.w@yahoo.com',
            'reviewer_province' => 'Bali',
            'rating' => 5,
            'comment' => 'Buku bagus banget! Mengubah cara pandang saya tentang uang dan investasi. Must read!',
        ]);

        ProductReview::create([
            'product_id' => 4,
            'reviewer_name' => 'Teguh Prasetyo',
            'reviewer_phone' => '087890123457',
            'reviewer_email' => 'teguh.p@gmail.com',
            'reviewer_province' => 'Sumatera Utara',
            'rating' => 5,
            'comment' => 'Isi bukunya relate banget sama kehidupan sehari-hari. Bahasanya mudah dipahami.',
        ]);

        // Review untuk Novel Laskar Pelangi
        ProductReview::create([
            'product_id' => 5,
            'reviewer_name' => 'Dewi Lestari',
            'reviewer_phone' => '088901234568',
            'reviewer_email' => 'dewi.lestari@gmail.com',
            'reviewer_province' => 'Kalimantan Timur',
            'rating' => 5,
            'comment' => 'Novel klasik Indonesia yang wajib dibaca! Ceritanya menyentuh hati.',
        ]);

        // Review untuk Buku Atomic Habits
        ProductReview::create([
            'product_id' => 6,
            'reviewer_name' => 'Agus Setiawan',
            'reviewer_phone' => '089012345679',
            'reviewer_email' => 'agus.s@outlook.com',
            'reviewer_province' => 'Sulawesi Selatan',
            'rating' => 5,
            'comment' => 'Buku self-improvement terbaik yang pernah saya baca. Langsung praktek tips-nya!',
        ]);

        ProductReview::create([
            'product_id' => 6,
            'reviewer_name' => 'Maya Sari',
            'reviewer_phone' => '081234567892',
            'reviewer_email' => 'maya.sari@gmail.com',
            'reviewer_province' => 'Lampung',
            'rating' => 4,
            'comment' => 'Isinya bagus, tapi beberapa konsep agak repetitif. Tetap recommended!',
        ]);

        // Review untuk Kemeja Pria
        ProductReview::create([
            'product_id' => 7,
            'reviewer_name' => 'Rudi Hartono',
            'reviewer_phone' => '082345678903',
            'reviewer_email' => 'rudi.h@gmail.com',
            'reviewer_province' => 'Banten',
            'rating' => 4,
            'comment' => 'Kemeja bagus, bahannya adem dan nyaman. Ukurannya pas sesuai size chart.',
        ]);

        // Review untuk Dress Wanita
        ProductReview::create([
            'product_id' => 8,
            'reviewer_name' => 'Lina Marlina',
            'reviewer_phone' => '083456789014',
            'reviewer_email' => 'lina.m@yahoo.com',
            'reviewer_province' => 'Jawa Barat',
            'rating' => 5,
            'comment' => 'Dress cantik, motifnya lucu, bahannya jatuh. Puas banget belanja disini!',
        ]);

        ProductReview::create([
            'product_id' => 8,
            'reviewer_name' => 'Sari Indah',
            'reviewer_phone' => '084567890125',
            'reviewer_email' => 'sari.indah@gmail.com',
            'reviewer_province' => 'Aceh',
            'rating' => 5,
            'comment' => 'Bahan adem banget, cocok buat cuaca panas. Modelnya juga timeless.',
        ]);

        // Review untuk Jaket Hoodie
        ProductReview::create([
            'product_id' => 9,
            'reviewer_name' => 'Bambang Wijaya',
            'reviewer_phone' => '085678901236',
            'reviewer_email' => 'bambang.w@gmail.com',
            'reviewer_province' => 'Sumatera Barat',
            'rating' => 4,
            'comment' => 'Jaket tebal dan hangat, cocok buat ke gunung. Harganya juga affordable.',
        ]);

        // Review untuk Raket Badminton
        ProductReview::create([
            'product_id' => 10,
            'reviewer_name' => 'Hendra Gunawan',
            'reviewer_phone' => '086789012347',
            'reviewer_email' => 'hendra.g@gmail.com',
            'reviewer_province' => 'DKI Jakarta',
            'rating' => 5,
            'comment' => 'Raket mantap! Smash kenceng, handle nyaman. Barang original, puas!',
        ]);

        ProductReview::create([
            'product_id' => 10,
            'reviewer_name' => 'Indra Pratama',
            'reviewer_phone' => '087890123458',
            'reviewer_email' => 'indra.p@outlook.com',
            'reviewer_province' => 'Jawa Timur',
            'rating' => 5,
            'comment' => 'Ini raket impian saya! Power dan kontrol balance. Worth the price!',
        ]);

        // Review untuk Sepatu Futsal
        ProductReview::create([
            'product_id' => 11,
            'reviewer_name' => 'Rizki Aditya',
            'reviewer_phone' => '088901234569',
            'reviewer_email' => 'rizki.aditya@gmail.com',
            'reviewer_province' => 'Riau',
            'rating' => 4,
            'comment' => 'Sepatu nyaman, grip-nya bagus di lapangan. Ukuran pas sesuai keterangan.',
        ]);

        // Review untuk Dumbbell Set
        ProductReview::create([
            'product_id' => 12,
            'reviewer_name' => 'Andi Wijaya',
            'reviewer_phone' => '089012345680',
            'reviewer_email' => 'andi.w@gmail.com',
            'reviewer_province' => 'Sulawesi Utara',
            'rating' => 5,
            'comment' => 'Dumbbell berkualitas, coating karetnya tebal. Cocok buat workout di rumah!',
        ]);

        // Review untuk Wardah Serum
        ProductReview::create([
            'product_id' => 13,
            'reviewer_name' => 'Putri Ayu',
            'reviewer_phone' => '081234567893',
            'reviewer_email' => 'putri.ayu@gmail.com',
            'reviewer_province' => 'Bali',
            'rating' => 5,
            'comment' => 'Serum favorit! Kulit jadi lebih cerah dalam 2 minggu. Harga terjangkau.',
        ]);

        ProductReview::create([
            'product_id' => 13,
            'reviewer_name' => 'Sinta Dewi',
            'reviewer_phone' => '082345678904',
            'reviewer_email' => 'sinta.d@yahoo.com',
            'reviewer_province' => 'Kalimantan Selatan',
            'rating' => 4,
            'comment' => 'Bagus sih, tapi butuh waktu untuk lihat hasil maksimal. Tetap repurchase!',
        ]);

        // Review untuk Emina Moisturizer
        ProductReview::create([
            'product_id' => 14,
            'reviewer_name' => 'Nina Safitri',
            'reviewer_phone' => '083456789015',
            'reviewer_email' => 'nina.s@gmail.com',
            'reviewer_province' => 'Papua',
            'rating' => 5,
            'comment' => 'Pelembab ringan, cepat meresap, nggak bikin wajah berminyak. Love it!',
        ]);

        // Review untuk Somethinc Serum
        ProductReview::create([
            'product_id' => 15,
            'reviewer_name' => 'Lia Amalia',
            'reviewer_phone' => '084567890126',
            'reviewer_email' => 'lia.amalia@gmail.com',
            'reviewer_province' => 'Jawa Tengah',
            'rating' => 5,
            'comment' => 'Serum terbaik untuk jerawat! Jerawat cepat kempes, bekas jerawat memudar.',
        ]);

        ProductReview::create([
            'product_id' => 15,
            'reviewer_name' => 'Dina Mariana',
            'reviewer_phone' => '085678901237',
            'reviewer_email' => 'dina.m@outlook.com',
            'reviewer_province' => 'Nusa Tenggara Barat',
            'rating' => 4,
            'comment' => 'Efektif untuk kulit berjerawat. Teksturnya ringan dan cepat menyerap. Recommended!',
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
