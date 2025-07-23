<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DigitalBrand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name']; 

    public function digitalProducts()
    {
        return $this->belongsToMany(DigitalProduct::class, 'digital_brand_product', 'digital_brand_id', 'digital_product_id');
    }

    public function digitalTransactions()
    {
        return $this->hasMany(DigitalTransaction::class, 'brand_id');
    }
}