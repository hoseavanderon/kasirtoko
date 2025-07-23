<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasukLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'jumlah_masuk',
    ];

    /**
     * Relasi ke model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}