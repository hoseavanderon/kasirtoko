<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_product',
        'stok',
        'last_restock_date',
        'last_sale_date',
        'minimal_stok',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}