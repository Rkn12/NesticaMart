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
        'rating',
        'comment',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ReviewProdukFactory::new();
    }

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
