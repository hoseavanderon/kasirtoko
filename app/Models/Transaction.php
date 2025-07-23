<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_item',
        'total_bayar',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'transaction_id');
    }
}
