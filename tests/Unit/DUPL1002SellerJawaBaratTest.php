<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * White Box Testing — DUPL-10-02
 * Kelas Uji : 10. Laporan Penjual per Provinsi
 * SKPL      : SRS-MartPlace-10
 * Fungsi    : ReportController::sellerByProvinceReport()
 *             — khususnya groupBy('province') untuk JAWA BARAT
 * Route     : GET /reports/seller-by-province?province=JAWA+BARAT
 */
class DUPL1002SellerJawaBaratTest extends TestCase
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
     * TC-01: Seller JAWA BARAT masuk kelompok JAWA BARAT setelah groupBy
     * Jalur: $sellers->groupBy('province') → key 'JAWA BARAT' berisi seller tersebut
     */
    public function test_DUPL1002_TC01_seller_jawa_barat_masuk_kelompok_jawa_barat()
    {
        $this->buatSeller([
            'store_name' => 'Cozy Home',
            'province'   => 'JAWA BARAT',
            'city'       => 'KOTA BANDUNG',
            'pic_name'   => 'Siti Rahayu',
        ]);

        $sellers = Seller::orderBy('province')->orderBy('city')->get();
        $grouped = $sellers->groupBy('province');

        $this->assertArrayHasKey('JAWA BARAT', $grouped->toArray());
        $this->assertEquals('Cozy Home', $grouped['JAWA BARAT']->first()->store_name);
    }

    /**
     * TC-02: Seller JAWA BARAT tidak muncul di kelompok provinsi lain
     * Jalur: groupBy memisahkan data — JAWA BARAT tidak masuk key provinsi lain
     */
    public function test_DUPL1002_TC02_seller_jawa_barat_tidak_masuk_kelompok_provinsi_lain()
    {
        $this->buatSeller(['province' => 'JAWA BARAT', 'store_name' => 'Cozy Home']);
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);

        $sellers = Seller::orderBy('province')->orderBy('city')->get();
        $grouped = $sellers->groupBy('province');

        // Seller JAWA BARAT tidak ada di kelompok DKI JAKARTA
        $namaTokoJakarta = $grouped['DKI JAKARTA']->pluck('store_name')->toArray();
        $this->assertNotContains('Cozy Home', $namaTokoJakarta);

        // Seller DKI JAKARTA tidak ada di kelompok JAWA BARAT
        $namaTokoJabar = $grouped['JAWA BARAT']->pluck('store_name')->toArray();
        $this->assertNotContains('Urban Living', $namaTokoJabar);
    }

    /**
     * TC-03: Filter province=JAWA BARAT hanya mengambil seller JAWA BARAT dari DB
     * Jalur: $query->where('province', 'JAWA BARAT') — query filter
     */
    public function test_DUPL1002_TC03_filter_where_province_hanya_ambil_seller_jawa_barat()
    {
        $this->buatSeller(['province' => 'JAWA BARAT',  'store_name' => 'Cozy Home']);
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);
        $this->buatSeller(['province' => 'BALI',        'store_name' => 'Bali Teak']);

        $sellers = Seller::where('province', 'JAWA BARAT')
                         ->orderBy('province')
                         ->orderBy('city')
                         ->get();

        $this->assertEquals(1, $sellers->count());
        $this->assertEquals('Cozy Home', $sellers->first()->store_name);
        $this->assertEquals('JAWA BARAT', $sellers->first()->province);
    }

    /**
     * TC-04: Response PDF 200 saat filter province=JAWA BARAT
     * Jalur: request dengan province → PDF digenerate → response 200
     */
    public function test_DUPL1002_TC04_response_pdf_200_saat_filter_jawa_barat()
    {
        $this->buatSeller([
            'province'   => 'JAWA BARAT',
            'store_name' => 'Cozy Home',
            'pic_name'   => 'Siti Rahayu',
        ]);

        $response = $this->get('/reports/seller-by-province?province=JAWA+BARAT');

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'application/pdf',
            $response->headers->get('content-type')
        );
    }

    /**
     * TC-05: Jika tidak ada seller JAWA BARAT, kelompok JAWA BARAT tidak muncul
     * Jalur: groupBy tidak membuat key jika tidak ada data dengan province tersebut
     */
    public function test_DUPL1002_TC05_tidak_ada_seller_jawa_barat_kelompok_tidak_muncul()
    {
        $this->buatSeller(['province' => 'DKI JAKARTA', 'store_name' => 'Urban Living']);
        $this->buatSeller(['province' => 'BALI',        'store_name' => 'Bali Teak']);

        $sellers = Seller::orderBy('province')->orderBy('city')->get();
        $grouped = $sellers->groupBy('province');

        $this->assertArrayNotHasKey('JAWA BARAT', $grouped->toArray());
    }
}
