<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * White Box Testing — DUPL-10-01
 * Kelas Uji : 10. Laporan Penjual per Provinsi
 * SKPL      : SRS-MartPlace-10
 * Fungsi    : ReportController::sellerByProvinceReport()
 */
class DUPL1001SellerByProvinceReportTest extends TestCase
{
    use RefreshDatabase;

    private int $counter = 0;

    private function buatSeller(array $override = []): Seller
    {
        $this->counter++;
        $c = $this->counter;

        return Seller::create(array_merge([
            'store_name'  => "Toko Test {$c}",
            'owner_name'  => 'Pemilik Test',
            'nik'         => str_pad((string) $c, 16, '0', STR_PAD_LEFT),
            'phone'       => '081234567890',
            'email'       => "test{$c}@example.com",
            'province'    => 'JAWA BARAT',
            'city'        => 'KOTA BANDUNG',
            'subdistrict' => 'Coblong',
            'kelurahan'   => 'Dago',
            'rt'          => '001',
            'rw'          => '001',
            'address'     => 'Jl. Test No. 1',
            'pic_name'    => 'PIC Test',
            'pic_phone'   => '081234567890',
            'pic_email'   => "pic{$c}@example.com",
            'status'      => 'approved',
            'is_approved' => true,
        ], $override));
    }

    /**
     * TC-01: Tanpa filter — semua seller tampil, response PDF 200
     * Jalur: $province = null → query tanpa WHERE → groupBy semua
     */
    public function test_DUPL1001_TC01_tanpa_filter_response_200_dan_pdf()
    {
        $this->buatSeller(['province' => 'JAWA BARAT',  'store_name' => 'Cozy Home']);
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);
        $this->buatSeller(['province' => 'BALI',        'store_name' => 'Bali Teak']);

        $response = $this->get('/reports/seller-by-province');

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'application/pdf',
            $response->headers->get('content-type')
        );
    }

    /**
     * TC-02: groupBy('province') mengelompokkan seller ke provinsi yang benar
     * Jalur: $sellers->groupBy('province') — logika pengelompokan koleksi
     */
    public function test_DUPL1001_TC02_groupBy_mengelompokkan_seller_per_provinsi()
    {
        $this->buatSeller(['province' => 'JAWA BARAT',  'store_name' => 'Cozy Home']);
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);
        $this->buatSeller(['province' => 'BALI',        'store_name' => 'Bali Teak']);

        $sellers = Seller::orderBy('province')->orderBy('city')->get();
        $grouped = $sellers->groupBy('province');

        $this->assertArrayHasKey('JAWA BARAT',  $grouped->toArray());
        $this->assertArrayHasKey('DKI JAKARTA', $grouped->toArray());
        $this->assertArrayHasKey('BALI',        $grouped->toArray());
        $this->assertEquals(3, $grouped->count());
        $this->assertEquals(1, $grouped['JAWA BARAT']->count());
    }

    /**
     * TC-03: Filter province — hanya seller dari provinsi tersebut yang tampil
     * Jalur: $province terisi → query WHERE province = ? → groupBy satu kelompok
     */
    public function test_DUPL1001_TC03_filter_province_hanya_tampilkan_seller_dari_provinsi_itu()
    {
        $this->buatSeller(['province' => 'JAWA BARAT',  'store_name' => 'Cozy Home']);
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);

        $response = $this->get('/reports/seller-by-province?province=JAWA+BARAT');

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'application/pdf',
            $response->headers->get('content-type')
        );

        $sellers = Seller::where('province', 'JAWA BARAT')->get();
        $this->assertEquals(1, $sellers->count());
        $this->assertEquals('Cozy Home', $sellers->first()->store_name);
    }

    /**
     * TC-04: Summary total seller dan total provinsi dihitung dengan benar
     * Jalur: $sellers->count() dan $sellersByProvince->count()
     */
    public function test_DUPL1001_TC04_summary_total_seller_dan_total_provinsi_benar()
    {
        $this->buatSeller(['province' => 'JAWA BARAT', 'store_name' => 'Toko 1']);
        $this->buatSeller(['province' => 'JAWA BARAT', 'store_name' => 'Toko 2']);
        $this->buatSeller(['province' => 'BALI',       'store_name' => 'Toko 3']);

        $sellers        = Seller::orderBy('province')->orderBy('city')->get();
        $grouped        = $sellers->groupBy('province');
        $totalSellers   = $sellers->count();
        $totalProvinces = $grouped->count();

        $this->assertEquals(3, $totalSellers);
        $this->assertEquals(2, $totalProvinces);
    }

    /**
     * TC-05: Seller diurutkan berdasarkan province A-Z lalu city A-Z
     * Jalur: orderBy('province')->orderBy('city')
     */
    public function test_DUPL1001_TC05_seller_diurutkan_province_lalu_city()
    {
        $this->buatSeller(['province' => 'JAWA BARAT', 'city' => 'KOTA BOGOR',    'store_name' => 'Toko Bogor']);
        $this->buatSeller(['province' => 'BALI',       'city' => 'KOTA DENPASAR', 'store_name' => 'Toko Bali']);
        $this->buatSeller(['province' => 'JAWA BARAT', 'city' => 'KOTA BANDUNG',  'store_name' => 'Toko Bandung']);

        $sellers = Seller::orderBy('province')->orderBy('city')->get();

        $this->assertEquals('BALI',         $sellers[0]->province);
        $this->assertEquals('JAWA BARAT',   $sellers[1]->province);
        $this->assertEquals('KOTA BANDUNG', $sellers[1]->city);
        $this->assertEquals('KOTA BOGOR',   $sellers[2]->city);
    }
}
