<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'verified_by',
        'status',
        'note',
    ];

    // Relasi ke seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
