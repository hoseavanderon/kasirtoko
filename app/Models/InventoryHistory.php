<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_product',
        'type_transaksi',
        'perubahan_stok',
        'keterangan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}