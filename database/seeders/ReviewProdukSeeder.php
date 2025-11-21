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

        // Buat review untuk setiap produk (0-5 review per produk)
        foreach ($products as $product) {
            $reviewCount = rand(0, 5);
            
            if ($reviewCount > 0) {
                ProductReview::factory()->count($reviewCount)->create([
                    'product_id' => $product->id,
                ]);

                // Update average rating produk
                $averageRating = $product->reviews()->avg('rating');
                $product->update(['average_rating' => round($averageRating, 2)]);
            }
        }
    }
}
