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
        // Seller 1 - Toko Elektronik Jakarta (Approved)
        Seller::create([
            'store_name' => 'Toko Elektronik Jakarta',
            'store_description' => 'Menjual berbagai macam elektronik berkualitas dengan harga terjangkau',
            'owner_name' => 'Budi Santoso',
            'nik' => '3174012345670001',
            'phone' => '081234567890',
            'email' => 'budi.elektronik@gmail.com',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Pusat',
            'subdistrict' => 'Tanah Abang',
            'kelurahan' => 'Petojo Selatan',
            'rt' => '005',
            'rw' => '003',
            'address' => 'Jl. Tanah Abang II No. 15',
            'pic_name' => 'Budi Santoso',
            'pic_phone' => '081234567890',
            'pic_email' => 'budi.elektronik@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 2 - Toko Buku Surabaya (Approved)
        Seller::create([
            'store_name' => 'Toko Buku Surabaya',
            'store_description' => 'Toko buku terlengkap di Surabaya, menjual buku pelajaran, novel, dan komik',
            'owner_name' => 'Siti Rahayu',
            'nik' => '3578012345670002',
            'phone' => '082345678901',
            'email' => 'siti.buku@gmail.com',
            'province' => 'Jawa Timur',
            'city' => 'Surabaya',
            'subdistrict' => 'Gubeng',
            'kelurahan' => 'Gubeng',
            'rt' => '002',
            'rw' => '001',
            'address' => 'Jl. Gubeng Pojok No. 20',
            'pic_name' => 'Siti Rahayu',
            'pic_phone' => '082345678901',
            'pic_email' => 'siti.buku@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 3 - Fashion Store Bandung (Approved)
        Seller::create([
            'store_name' => 'Fashion Store Bandung',
            'store_description' => 'Toko fashion dengan koleksi pakaian trendy dan berkualitas',
            'owner_name' => 'Andi Wijaya',
            'nik' => '3273012345670003',
            'phone' => '083456789012',
            'email' => 'andi.fashion@gmail.com',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'subdistrict' => 'Coblong',
            'kelurahan' => 'Dago',
            'rt' => '003',
            'rw' => '002',
            'address' => 'Jl. Dago No. 88',
            'pic_name' => 'Andi Wijaya',
            'pic_phone' => '083456789012',
            'pic_email' => 'andi.fashion@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 4 - Toko Alat Olahraga Jogja (Approved)
        Seller::create([
            'store_name' => 'Toko Alat Olahraga Jogja',
            'store_description' => 'Menyediakan berbagai peralatan olahraga untuk fitness, sepak bola, badminton',
            'owner_name' => 'Dedi Prasetyo',
            'nik' => '3471012345670004',
            'phone' => '084567890123',
            'email' => 'dedi.sport@gmail.com',
            'province' => 'DI Yogyakarta',
            'city' => 'Yogyakarta',
            'subdistrict' => 'Gondokusuman',
            'kelurahan' => 'Terban',
            'rt' => '001',
            'rw' => '004',
            'address' => 'Jl. Kaliurang KM 5',
            'pic_name' => 'Dedi Prasetyo',
            'pic_phone' => '084567890123',
            'pic_email' => 'dedi.sport@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 5 - Toko Kosmetik Bali (Approved)
        Seller::create([
            'store_name' => 'Toko Kosmetik Bali',
            'store_description' => 'Toko kosmetik dan skincare asli dengan produk berkualitas',
            'owner_name' => 'Made Suartini',
            'nik' => '5171012345670005',
            'phone' => '085678901234',
            'email' => 'made.kosmetik@gmail.com',
            'province' => 'Bali',
            'city' => 'Denpasar',
            'subdistrict' => 'Denpasar Selatan',
            'kelurahan' => 'Sanur',
            'rt' => '007',
            'rw' => '005',
            'address' => 'Jl. Danau Tamblingan No. 50',
            'pic_name' => 'Made Suartini',
            'pic_phone' => '085678901234',
            'pic_email' => 'made.kosmetik@gmail.com',
            'status' => 'approved',
            'is_approved' => true,
            'is_active' => true,
        ]);

        // Seller 6 - Toko Furniture Medan (Pending)
        Seller::create([
            'store_name' => 'Toko Furniture Medan',
            'store_description' => 'Menjual furniture rumah tangga berkualitas tinggi',
            'owner_name' => 'Hendra Gunawan',
            'nik' => '1271012345670006',
            'phone' => '086789012345',
            'email' => 'hendra.furniture@gmail.com',
            'province' => 'Sumatera Utara',
            'city' => 'Medan',
            'subdistrict' => 'Medan Baru',
            'kelurahan' => 'Babura',
            'rt' => '008',
            'rw' => '006',
            'address' => 'Jl. Imam Bonjol No. 100',
            'pic_name' => 'Hendra Gunawan',
            'pic_phone' => '086789012345',
            'pic_email' => 'hendra.furniture@gmail.com',
            'status' => 'pending',
        ]);

        // Seller 7 - Toko Makanan Semarang (Pending)
        Seller::create([
            'store_name' => 'Toko Makanan Semarang',
            'store_description' => 'Jual makanan khas Semarang dan oleh-oleh',
            'owner_name' => 'Linda Kusuma',
            'nik' => '3374012345670007',
            'phone' => '087890123456',
            'email' => 'linda.makanan@gmail.com',
            'province' => 'Jawa Tengah',
            'city' => 'Semarang',
            'subdistrict' => 'Semarang Tengah',
            'kelurahan' => 'Pandanaran',
            'rt' => '004',
            'rw' => '008',
            'address' => 'Jl. Pandanaran No. 25',
            'pic_name' => 'Linda Kusuma',
            'pic_phone' => '087890123456',
            'pic_email' => 'linda.makanan@gmail.com',
            'status' => 'pending',
        ]);

        // Seller 8 - Toko Mainan Palembang (Rejected)
        Seller::create([
            'store_name' => 'Toko Mainan Palembang',
            'store_description' => 'Toko mainan anak-anak terlengkap',
            'owner_name' => 'Rizki Aditya',
            'nik' => '1671012345670008',
            'phone' => '088901234567',
            'email' => 'rizki.mainan@gmail.com',
            'province' => 'Sumatera Selatan',
            'city' => 'Palembang',
            'subdistrict' => 'Ilir Timur I',
            'kelurahan' => '19 Ilir',
            'rt' => '006',
            'rw' => '007',
            'address' => 'Jl. Kapten A. Rivai No. 15',
            'pic_name' => 'Rizki Aditya',
            'pic_phone' => '088901234567',
            'pic_email' => 'rizki.mainan@gmail.com',
            'status' => 'rejected',
            'verification_note' => 'Dokumen KTP tidak valid',
        ]);
    }
}
