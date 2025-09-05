<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_category_id',
        'nama',
    ];

    public function category()
    {
        return $this->belongsTo(DigitalCategory::class, 'digital_category_id');
    }

    public function brands()
    {
        return $this->belongsToMany(DigitalBrand::class, 'digital_brand_product', 'digital_product_id', 'digital_brand_id');
    }
}
