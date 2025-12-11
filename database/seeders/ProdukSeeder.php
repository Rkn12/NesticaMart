<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
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

        // Seller 1: Urban Living (Sofas, Cabinets)
        $p1 = Product::create([
            'seller_id' => 1,
            'category_id' => $categories->where('name', 'Sofas')->first()->id,
            'name' => 'Modern Grey Sectional Sofa',
            'description' => 'Spacious L-shaped sectional sofa upholstered in premium grey fabric. Perfect for modern living rooms.',
            'price' => 8500000,
            'stock' => 10,
            'sold_count' => 45,
            'weight' => 45000,
            'condition' => 'new',
            'location_province' => 'DKI Jakarta',
            'location_city' => 'Jakarta Selatan',
            'material_title' => 'Premium Fabric & Solid Wood Frame',
            'material_description' => 'Constructed with a kiln-dried hardwood frame for durability. Upholstered in high-quality, stain-resistant polyester fabric. Cushions are filled with high-density foam for long-lasting comfort.',
        ]);
        ProductImage::create(['product_id' => $p1->id, 'image_url' => 'images/seeds/sofa-grey.jpg']);

        $p2 = Product::create([
            'seller_id' => 1,
            'category_id' => $categories->where('name', 'Cabinets')->first()->id,
            'name' => 'Minimalist TV Console',
            'description' => 'Sleek TV console with ample storage space. Features a matte white finish and natural wood accents.',
            'price' => 2500000,
            'stock' => 20,
            'sold_count' => 89,
            'weight' => 15000,
            'condition' => 'new',
            'location_province' => 'DKI Jakarta',
            'location_city' => 'Jakarta Selatan',
            'material_title' => 'Engineered Wood & Oak Veneer',
            'material_description' => 'Made from high-grade MDF with a durable laminate finish. Legs are solid oak wood. Easy to clean and scratch-resistant surface.',
        ]);
        ProductImage::create(['product_id' => $p2->id, 'image_url' => 'images/seeds/tv-console.jpg']);

        // Seller 2: Cozy Home (Beds, Decorations)
        $p3 = Product::create([
            'seller_id' => 2,
            'category_id' => $categories->where('name', 'Beds')->first()->id,
            'name' => 'Queen Size Upholstered Bed Frame',
            'description' => 'Elegant queen size bed frame with a tufted headboard. Adds a touch of luxury to your bedroom.',
            'price' => 4200000,
            'stock' => 15,
            'sold_count' => 32,
            'weight' => 35000,
            'condition' => 'new',
            'location_province' => 'Jawa Barat',
            'location_city' => 'Bandung',
            'material_title' => 'Velvet Fabric & Steel Frame',
            'material_description' => 'Sturdy steel internal frame with wooden slats to support the mattress. Headboard is padded with foam and covered in soft velvet fabric.',
        ]);
        ProductImage::create(['product_id' => $p3->id, 'image_url' => 'images/seeds/bed-frame.jpg']);

        $p4 = Product::create([
            'seller_id' => 2,
            'category_id' => $categories->where('name', 'Decorations')->first()->id,
            'name' => 'Set of 3 Abstract Canvas Prints',
            'description' => 'Modern abstract art prints on high-quality canvas. Ready to hang and perfect for wall decor.',
            'price' => 450000,
            'stock' => 50,
            'sold_count' => 120,
            'weight' => 2000,
            'condition' => 'new',
            'location_province' => 'Jawa Barat',
            'location_city' => 'Bandung',
            'material_title' => 'Cotton Canvas & Pine Wood',
            'material_description' => 'Printed on 100% cotton canvas using fade-resistant inks. Stretched over a lightweight pine wood frame.',
        ]);
        ProductImage::create(['product_id' => $p4->id, 'image_url' => 'images/seeds/canvas-print.jpg']);

        // Seller 3: Rustic Woodworks (Tables & Chairs, Cabinets)
        $p5 = Product::create([
            'seller_id' => 3,
            'category_id' => $categories->where('name', 'Tables & Chairs')->first()->id,
            'name' => 'Teak Wood Dining Table (6 Seater)',
            'description' => 'Handcrafted solid teak wood dining table. Features a natural finish that highlights the wood grain.',
            'price' => 6500000,
            'stock' => 8,
            'sold_count' => 15,
            'weight' => 50000,
            'condition' => 'new',
            'location_province' => 'DI Yogyakarta',
            'location_city' => 'Yogyakarta',
            'material_title' => 'Solid Teak Wood',
            'material_description' => '100% solid teak wood sourced from sustainable plantations. Finished with a natural oil to protect the wood and enhance its beauty.',
        ]);
        ProductImage::create(['product_id' => $p5->id, 'image_url' => 'images/seeds/dining-table.jpg']);

        $p6 = Product::create([
            'seller_id' => 3,
            'category_id' => $categories->where('name', 'Tables & Chairs')->first()->id,
            'name' => 'Rustic Wooden Dining Chair',
            'description' => 'Sturdy wooden dining chair with a comfortable contoured seat. Matches perfectly with our teak dining table.',
            'price' => 850000,
            'stock' => 40,
            'sold_count' => 150,
            'weight' => 6000,
            'condition' => 'new',
            'location_province' => 'DI Yogyakarta',
            'location_city' => 'Yogyakarta',
            'material_title' => 'Solid Teak Wood',
            'material_description' => 'Hand-carved from solid teak wood. Durable and long-lasting construction.',
        ]);
        ProductImage::create(['product_id' => $p6->id, 'image_url' => 'images/seeds/dining-chair.jpg']);

        // Seller 4: Modern Furnishings (Lighting, Lamps)
        $p7 = Product::create([
            'seller_id' => 4,
            'category_id' => $categories->where('name', 'Lamps')->first()->id,
            'name' => 'Industrial Floor Lamp',
            'description' => 'Stylish industrial floor lamp with a black metal finish and adjustable head. Great for reading corners.',
            'price' => 1200000,
            'stock' => 25,
            'sold_count' => 67,
            'weight' => 4000,
            'condition' => 'new',
            'location_province' => 'Jawa Timur',
            'location_city' => 'Surabaya',
            'material_title' => 'Metal & Iron',
            'material_description' => 'Constructed from high-quality iron with a matte black powder coating. Heavy base for stability.',
        ]);
        ProductImage::create(['product_id' => $p7->id, 'image_url' => 'images/seeds/floor-lamp.jpg']);

        $p8 = Product::create([
            'seller_id' => 4,
            'category_id' => $categories->where('name', 'Lighting')->first()->id,
            'name' => 'Modern Pendant Light',
            'description' => 'Minimalist pendant light with a glass shade. Adds a warm glow to your dining area or kitchen island.',
            'price' => 750000,
            'stock' => 30,
            'sold_count' => 95,
            'weight' => 1500,
            'condition' => 'new',
            'location_province' => 'Jawa Timur',
            'location_city' => 'Surabaya',
            'material_title' => 'Glass & Brass',
            'material_description' => 'Hand-blown glass shade with brass fittings. Includes a 1-meter adjustable cord.',
        ]);
        ProductImage::create(['product_id' => $p8->id, 'image_url' => 'images/seeds/pendant-light.jpg']);

        // Seller 5: Bali Teak & Rattan (Tables & Chairs, Decorations)
        $p9 = Product::create([
            'seller_id' => 5,
            'category_id' => $categories->where('name', 'Tables & Chairs')->first()->id,
            'name' => 'Rattan Lounge Chair',
            'description' => 'Comfortable lounge chair made from natural rattan. Perfect for indoor or covered outdoor spaces.',
            'price' => 1800000,
            'stock' => 12,
            'sold_count' => 55,
            'weight' => 5000,
            'condition' => 'new',
            'location_province' => 'Bali',
            'location_city' => 'Denpasar',
            'material_title' => 'Natural Rattan',
            'material_description' => 'Handwoven from natural rattan vines. Eco-friendly and sustainable material.',
        ]);
        ProductImage::create(['product_id' => $p9->id, 'image_url' => 'images/seeds/rattan-chair.jpg']);

    }
}
