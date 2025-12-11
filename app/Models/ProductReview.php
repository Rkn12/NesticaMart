<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reviewer_name',
        'reviewer_phone',
        'reviewer_email',
        'reviewer_province',
        'rating',
        'review_title',
        'comment',
        'photos',
        'video',
    ];

    protected $casts = [
        'photos' => 'array', // Cast JSON to array
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
