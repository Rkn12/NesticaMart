<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'change_type',
        'quantity_change',
        'stock_before',
        'stock_after',
        'notes',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
