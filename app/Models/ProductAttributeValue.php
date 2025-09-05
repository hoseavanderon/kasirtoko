<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_attribute_id',
        'attribute_value',
        'stok',
        'last_restock_date',
        'last_sale_date',
        'user_id',
    ];

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
