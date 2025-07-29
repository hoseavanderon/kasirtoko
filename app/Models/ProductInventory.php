<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'stok',
        'last_restock_date',
        'last_sale_date',
        'minimal_stok',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}