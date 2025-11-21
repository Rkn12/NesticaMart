<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'sold_count',
        'weight',
        'condition',
        'location_province',
        'location_city',
        'average_rating',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ProdukFactory::new();
    }

    // Relasi ke seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Relasi ke gambar produk
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relasi ke review
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    // Relasi ke log stok
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }
}
