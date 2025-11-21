<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'old_status',
        'new_status',
        'notes',
        'verified_by',
    ];

    // Relasi ke seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
