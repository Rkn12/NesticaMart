<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seller 1 - Urban Living (Approved)
        Seller::create([
            'store_name' => 'Urban Living',
            'store_description' => 'Modern furniture for urban lifestyle',
            'owner_name' => 'Budi Santoso',
            'nik' => '3174012345670001',
            'phone' => '081234567890',
            'email' => 'budi.urban@gmail.com',
            'province' => 'DAERAH KHUSUS IBUKOTA JAKARTA',
            'city' => 'KOTA JAKARTA SELATAN',
            'subdistrict' => 'Kebayoran Baru',
            'kelurahan' => 'Senayan',
            'rt' => '005',
            'rw' => '003',
            'address' => 'Jl. Senopati No. 10',
            'pic_name' => 'Budi Santoso',
            'pic_phone' => '081234567890',
            'pic_email' => 'budi.urban@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 2 - Cozy Home (Approved)
        Seller::create([
            'store_name' => 'Cozy Home',
            'store_description' => 'Comfortable furniture for your cozy home',
            'owner_name' => 'Siti Rahayu',
            'nik' => '3578012345670002',
            'phone' => '082345678901',
            'email' => 'siti.cozy@gmail.com',
            'province' => 'JAWA BARAT',
            'city' => 'KOTA BANDUNG',
            'subdistrict' => 'Coblong',
            'kelurahan' => 'Dago',
            'rt' => '002',
            'rw' => '001',
            'address' => 'Jl. Dago No. 20',
            'pic_name' => 'Siti Rahayu',
            'pic_phone' => '082345678901',
            'pic_email' => 'siti.cozy@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 3 - Rustic Woodworks (Approved)
        Seller::create([
            'store_name' => 'Rustic Woodworks',
            'store_description' => 'Handcrafted wooden furniture',
            'owner_name' => 'Andi Wijaya',
            'nik' => '3273012345670003',
            'phone' => '083456789012',
            'email' => 'andi.rustic@gmail.com',
            'province' => 'DI YOGYAKARTA',
            'city' => 'KOTA YOGYAKARTA',
            'subdistrict' => 'Kotagede',
            'kelurahan' => 'Prenggan',
            'rt' => '003',
            'rw' => '002',
            'address' => 'Jl. Mondorakan No. 5',
            'pic_name' => 'Andi Wijaya',
            'pic_phone' => '083456789012',
            'pic_email' => 'andi.rustic@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 4 - Modern Furnishings (Approved)
        Seller::create([
            'store_name' => 'Modern Furnishings',
            'store_description' => 'Contemporary furniture designs',
            'owner_name' => 'Dedi Prasetyo',
            'nik' => '3471012345670004',
            'phone' => '084567890123',
            'email' => 'dedi.modern@gmail.com',
            'province' => 'JAWA TIMUR',
            'city' => 'KOTA SURABAYA',
            'subdistrict' => 'Gubeng',
            'kelurahan' => 'Gubeng',
            'rt' => '001',
            'rw' => '004',
            'address' => 'Jl. Gubeng No. 15',
            'pic_name' => 'Dedi Prasetyo',
            'pic_phone' => '084567890123',
            'pic_email' => 'dedi.modern@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 5 - Bali Teak & Rattan (Approved)
        Seller::create([
            'store_name' => 'Bali Teak & Rattan',
            'store_description' => 'Authentic Balinese teak and rattan furniture',
            'owner_name' => 'Made Suartini',
            'nik' => '5171012345670005',
            'phone' => '085678901234',
            'email' => 'made.bali@gmail.com',
            'province' => 'BALI',
            'city' => 'KOTA DENPASAR',
            'subdistrict' => 'Denpasar Selatan',
            'kelurahan' => 'Sanur',
            'rt' => '007',
            'rw' => '005',
            'address' => 'Jl. Danau Tamblingan No. 50',
            'pic_name' => 'Made Suartini',
            'pic_phone' => '085678901234',
            'pic_email' => 'made.bali@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 6 - Medan Woodcraft (Pending)
        Seller::create([
            'store_name' => 'Medan Woodcraft',
            'store_description' => 'High quality solid wood furniture from Medan',
            'owner_name' => 'Hendra Gunawan',
            'nik' => '1271012345670006',
            'phone' => '086789012345',
            'email' => 'hendra.wood@gmail.com',
            'province' => 'SUMATERA UTARA',
            'city' => 'KOTA MEDAN',
            'subdistrict' => 'Medan Baru',
            'kelurahan' => 'Babura',
            'rt' => '008',
            'rw' => '006',
            'address' => 'Jl. Imam Bonjol No. 100',
            'pic_name' => 'Hendra Gunawan',
            'pic_phone' => '086789012345',
            'pic_email' => 'hendra.wood@gmail.com',
            'status' => 'pending',
        ]);

        // Seller 7 - Semarang Carvings (Pending)
        Seller::create([
            'store_name' => 'Semarang Carvings',
            'store_description' => 'Traditional Javanese wood carvings and furniture',
            'owner_name' => 'Linda Kusuma',
            'nik' => '3374012345670007',
            'phone' => '087890123456',
            'email' => 'linda.carvings@gmail.com',
            'province' => 'JAWA TENGAH',
            'city' => 'KOTA SEMARANG',
            'subdistrict' => 'Semarang Tengah',
            'kelurahan' => 'Pandanaran',
            'rt' => '004',
            'rw' => '008',
            'address' => 'Jl. Pandanaran No. 25',
            'pic_name' => 'Linda Kusuma',
            'pic_phone' => '087890123456',
            'pic_email' => 'linda.carvings@gmail.com',
            'status' => 'pending',
        ]);

        // Seller 8 - Palembang Decor (Rejected)
        Seller::create([
            'store_name' => 'Palembang Decor',
            'store_description' => 'Unique home decoration items',
            'owner_name' => 'Rizki Aditya',
            'nik' => '1671012345670008',
            'phone' => '088901234567',
            'email' => 'rizki.decor@gmail.com',
            'province' => 'SUMATERA SELATAN',
            'city' => 'KOTA PALEMBANG',
            'subdistrict' => 'Ilir Timur I',
            'kelurahan' => '19 Ilir',
            'rt' => '006',
            'rw' => '007',
            'address' => 'Jl. Kapten A. Rivai No. 15',
            'pic_name' => 'Rizki Aditya',
            'pic_phone' => '088901234567',
            'pic_email' => 'rizki.decor@gmail.com',
            'status' => 'rejected',
            'verification_note' => 'Dokumen KTP tidak valid',
        ]);
    }
}
