<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * White Box Testing — DUPL-01-01
 * Kelas Uji : 1. Registrasi Penjual
 * SKPL      : SRS-MartPlace-01
 * Fungsi    : SellerController::register(Request $request)
 * Route     : POST /api/sellers/register
 */
class DUPL0101SellerRegistrationTest extends TestCase
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
            'email'             => 'budi@tokомajujaya.com',
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
     * TC-01: Data valid — seller berhasil disimpan ke database
     * Jalur: validasi lolos → Seller::create() → response 201
     */
    public function test_DUPL0101_TC01_registrasi_data_valid_berhasil_disimpan()
    {
        $response = $this->postJson('/api/sellers/register', $this->dataValid());

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Registrasi berhasil. Menunggu verifikasi admin.',
                 ]);

        $this->assertDatabaseHas('sellers', [
            'store_name' => 'Toko Maju Jaya',
            'email'      => 'budi@tokомajujaya.com',
            'status'     => 'pending',
        ]);
    }

    /**
     * TC-02: Status default 'pending' setelah registrasi berhasil
     * Jalur: Seller::create() selalu set status = 'pending'
     */
    public function test_DUPL0101_TC02_status_default_pending_setelah_registrasi()
    {
        $this->postJson('/api/sellers/register', $this->dataValid());

        $seller = Seller::where('email', 'budi@tokомajujaya.com')->first();

        $this->assertNotNull($seller);
        $this->assertEquals('pending', $seller->status);
    }

    /**
     * TC-03: Field wajib kosong — validasi gagal, response 422
     * Jalur: $validator->fails() → return 422 dengan errors
     */
    public function test_DUPL0101_TC03_field_wajib_kosong_response_422()
    {
        $response = $this->postJson('/api/sellers/register', []);

        $response->assertStatus(422)
                 ->assertJson(['success' => false])
                 ->assertJsonStructure(['errors' => [
                     'store_name',
                     'owner_name',
                     'nik',
                     'email',
                     'province',
                     'city',
                 ]]);
    }

    /**
     * TC-04: NIK duplikat — validasi unique:sellers,nik gagal
     * Jalur: $validator->fails() karena NIK sudah terdaftar
     */
    public function test_DUPL0101_TC04_nik_duplikat_response_422()
    {
        // Daftarkan penjual pertama
        $this->postJson('/api/sellers/register', $this->dataValid());

        // Daftarkan penjual kedua dengan NIK yang sama
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'email' => 'lain@example.com', // email beda tapi NIK sama
        ]));

        $response->assertStatus(422)
                 ->assertJson(['success' => false])
                 ->assertJsonPath('errors.nik.0', fn($v) => str_contains($v, 'taken') || str_contains($v, 'sudah'));
    }

    /**
     * TC-05: Email duplikat — validasi unique:sellers,email gagal
     * Jalur: $validator->fails() karena email sudah terdaftar
     */
    public function test_DUPL0101_TC05_email_duplikat_response_422()
    {
        // Daftarkan penjual pertama
        $this->postJson('/api/sellers/register', $this->dataValid());

        // Daftarkan penjual kedua dengan email yang sama
        $response = $this->postJson('/api/sellers/register', $this->dataValid([
            'nik' => '9999999999999999', // NIK beda tapi email sama
        ]));

        $response->assertStatus(422)
                 ->assertJson(['success' => false])
                 ->assertJsonPath('errors.email.0', fn($v) => str_contains($v, 'taken') || str_contains($v, 'sudah'));
    }

    /**
     * TC-06: Semua field tersimpan sesuai input
     * Jalur: data dari $request dipetakan satu-per-satu ke Seller::create()
     */
    public function test_DUPL0101_TC06_semua_field_tersimpan_sesuai_input()
    {
        $data = $this->dataValid();

        $this->postJson('/api/sellers/register', $data);

        $this->assertDatabaseHas('sellers', [
            'store_name'  => $data['store_name'],
            'owner_name'  => $data['owner_name'],
            'nik'         => $data['nik'],
            'phone'       => $data['phone'],
            'email'       => $data['email'],
            'province'    => $data['province'],
            'city'        => $data['city'],
            'address'     => $data['address'],
            'pic_name'    => $data['pic_name'],
            'pic_email'   => $data['pic_email'],
        ]);
    }
}
