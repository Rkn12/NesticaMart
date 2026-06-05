<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * White Box Testing — DUPL-01-02
 * Kelas Uji : 1. Registrasi Penjual
 * SKPL      : SRS-MartPlace-01
 * Fungsi    : SellerController::register() — field store_name
 * Route     : POST /api/sellers/register
 */
class DUPL0102StoreNameTest extends TestCase
{
    use RefreshDatabase;

    private function dataValid(array $override = []): array
    {
        return array_merge([
            'store_name'        => 'Toko Maju Jaya',
            'store_description' => 'Toko furniture berkualitas',
            'owner_name'        => 'Budi Santoso',
            'nik'               => '3174012345670001',
            'phone'             => '081234567890',
            'email'             => 'budi@example.com',
            'province'          => 'JAWA BARAT',
            'city'              => 'KOTA BANDUNG',
            'subdistrict'       => 'Coblong',
            'kelurahan'         => 'Dago',
            'rt'                => '001',
            'rw'                => '001',
            'address'           => 'Jl. Dago No. 10',
            'pic_name'          => 'Budi Santoso',
            'pic_phone'         => '081234567890',
            'pic_email'         => 'budi@example.com',
        ], $override);
    }

    /**
     * TC-01: store_name tersimpan di database sesuai input
     * Jalur: $request->store_name → Seller::create(['store_name' => ...])
     */
    public function test_DUPL0102_TC01_store_name_tersimpan_sesuai_input()
    {
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'store_name' => 'Toko Maju Jaya',
        ]));

        $response->assertStatus(201);

        $this->assertDatabaseHas('sellers', [
            'store_name' => 'Toko Maju Jaya',
        ]);
    }

    /**
     * TC-02: store_name di response JSON sama dengan input
     * Jalur: return response()->json(['data' => $seller]) — field store_name
     */
    public function test_DUPL0102_TC02_store_name_di_response_sama_dengan_input()
    {
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'store_name' => 'Toko Maju Jaya',
        ]));

        $response->assertStatus(201)
                 ->assertJsonPath('data.store_name', 'Toko Maju Jaya');
    }

    /**
     * TC-03: store_name dengan spasi dan karakter khusus tersimpan utuh
     * Jalur: tidak ada transformasi string pada store_name sebelum disimpan
     */
    public function test_DUPL0102_TC03_store_name_dengan_spasi_tersimpan_utuh()
    {
        $namaToko = 'Bali Teak & Rattan Shop';

        $this->postJson('/api/sellers/register', $this->dataValid([
            'store_name' => $namaToko,
        ]));

        $this->assertDatabaseHas('sellers', [
            'store_name' => $namaToko,
        ]);
    }

    /**
     * TC-04: store_name kosong — validasi gagal, tidak tersimpan
     * Jalur: $validator->fails() karena store_name required
     */
    public function test_DUPL0102_TC04_store_name_kosong_tidak_tersimpan()
    {
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'store_name' => '',
        ]));

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors' => ['store_name']]);

        $this->assertDatabaseCount('sellers', 0);
    }

    /**
     * TC-05: store_name melebihi 150 karakter — validasi gagal
     * Jalur: $validator->fails() karena store_name max:150
     */
    public function test_DUPL0102_TC05_store_name_melebihi_150_karakter_ditolak()
    {
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'store_name' => str_repeat('A', 151),
        ]));

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors' => ['store_name']]);

        $this->assertDatabaseCount('sellers', 0);
    }
}
