<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'digital_product_id',
        'brand_id',
        'keterangan',
        'product_detail',
        'harga_jual',
        'transaction_date',
        'user_id',
    ];
    
    public function digitalProduct()
    {
        return $this->belongsTo(DigitalProduct::class, 'digital_product_id');
    }

    public function brand()
    {
        // Sebuah transaksi mungkin terkait dengan satu brand (nullable)
        return $this->belongsTo(DigitalBrand::class, 'brand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}