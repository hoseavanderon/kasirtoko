<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function products()
    {
        return $this->belongsToMany(DigitalProduct::class, 'digital_brand_product', 'digital_brand_id', 'digital_product_id');
    }
}
