<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\SellerReportController;

class StokTipisTest extends TestCase
{
    /**
     * DUPL-14-01
     * Memastikan produk dengan stok kurang dari 2 dapat teridentifikasi oleh sistem
     */
    public function test_dupl_14_01()
    {
        $controller = new SellerReportController();

        $response = $controller->previewLowStock(1);

        $data = $response->getData(true);

        foreach ($data['data']['products'] as $product) {
            $this->assertTrue(
                $product['stock'] < 2,
                "Produk {$product['name']} memiliki stok >= 2"
            );
        }
    }

    /**
     * DUPL-14-02
     * Memastikan daftar produk stok menipis tampil sesuai data yang tersedia
     */
    public function test_dupl_14_02()
    {
        $controller = new SellerReportController();

        $response = $controller->previewLowStock(1);

        $data = $response->getData(true);

        $products = collect($data['data']['products']);

        $expectedOutOfStock =
            $products->where('stock', 0)->count();

        $expectedCriticalStock =
            $products->where('stock', 1)->count();

        $actualOutOfStock =
            $data['data']['summary']['out_of_stock'];

        $actualCriticalStock =
            $data['data']['summary']['critical_stock'];

        $this->assertEquals(
            $expectedOutOfStock,
            $actualOutOfStock,
            'Jumlah out_of_stock tidak sesuai'
        );

        $this->assertEquals(
            $expectedCriticalStock,
            $actualCriticalStock,
            'Jumlah critical_stock tidak sesuai'
        );
    }
}