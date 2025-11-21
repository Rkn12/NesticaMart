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
        // Ambil seller yang sudah approved
        $approvedSellers = Seller::where('status', 'approved')->get();

        if ($approvedSellers->isEmpty()) {
            $this->command->warn('Tidak ada seller yang approved. Jalankan SellerSeeder terlebih dahulu.');
            return;
        }

        // Buat 20 produk dari seller yang sudah approved
        foreach ($approvedSellers as $seller) {
            Product::factory()->count(rand(3, 5))->create([
                'seller_id' => $seller->id,
            ]);
        }
    }
}
