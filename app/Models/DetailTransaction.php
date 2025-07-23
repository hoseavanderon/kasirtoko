<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'product_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}