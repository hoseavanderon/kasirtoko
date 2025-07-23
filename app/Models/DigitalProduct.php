<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_category_id',
        'name',
    ];

    public function digitalCategory()
    {
        return $this->belongsTo(DigitalCategory::class, 'digital_category_id');
    }

    public function digitalBrands()
    {
        return $this->belongsToMany(DigitalBrand::class, 'digital_brand_product', 'digital_product_id', 'digital_brand_id');
    }

    public function digitalTransactions()
    {
        return $this->hasMany(DigitalTransaction::class, 'digital_product_id');
    }
}
