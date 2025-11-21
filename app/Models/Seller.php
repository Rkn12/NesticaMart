<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_description',
        'owner_name',
        'nik',
        'phone',
        'email',
        'province',
        'city',
        'subdistrict',
        'kelurahan',
        'rt',
        'rw',
        'address',
        'pic_name',
        'pic_phone',
        'pic_email',
        'foto_ktp_pic',
        'file_ktp_pic',
        'status',
        'verification_note',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\PenjualFactory::new();
    }

    // Relasi ke produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Log verifikasi
    public function verificationLogs()
    {
        return $this->hasMany(VerificationLog::class);
    }
}
