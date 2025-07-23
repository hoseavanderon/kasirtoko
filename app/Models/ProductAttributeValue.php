<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_product', 'id_attribute', 'attribute_value'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'id_attribute');
    }
}
