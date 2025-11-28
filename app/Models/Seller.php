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
        'verification_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Generate a verification token for the seller
     */
    public function generateVerificationToken()
    {
        $this->verification_token = bin2hex(random_bytes(32));
        $this->save();
        return $this->verification_token;
    }

    /**
     * Check if seller email is verified
     */
    public function isEmailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->verification_token = null;
        $this->save();
    }

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
