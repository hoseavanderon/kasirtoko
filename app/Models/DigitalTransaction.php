<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'digital_product_id',
        'digital_brand_id',
        'keterangan',
        'harga_jual',
        'user_id',
    ];

    public function digitalProduct()
    {
        return $this->belongsTo(DigitalProduct::class, 'digital_product_id');
    }

    public function digitalBrand()
    {
        return $this->belongsTo(DigitalBrand::class, 'digital_brand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
