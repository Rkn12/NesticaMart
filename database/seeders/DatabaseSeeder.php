<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create platform admin
        User::factory()->create([
            'name' => 'Platform Admin',
            'email' => 'admin@platform.com',
            'role' => 'platform',
        ]);

        // Create test user (pengunjung)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'pengunjung',
        ]);

        // Seed kategori produk dan penjual terlebih dahulu
        $this->call([
            KategoriProdukSeeder::class,
            PenjualSeeder::class,
        ]);

        // Create penjual users (linked to approved sellers)
        User::factory()->create([
            'name' => 'Penjual 1',
            'email' => 'penjual1@example.com',
            'role' => 'penjual',
            'seller_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Penjual 2',
            'email' => 'penjual2@example.com',
            'role' => 'penjual',
            'seller_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Penjual 3',
            'email' => 'penjual3@example.com',
            'role' => 'penjual',
            'seller_id' => 3,
        ]);

        // Seed produk dan review
        $this->call([
            ProdukSeeder::class,
            ReviewProdukSeeder::class,
        ]);
    }
}
