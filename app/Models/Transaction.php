<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_nota',
        'subtotal',
        'dibayar',
        'kembalian',
        'user_id',
        'is_lunas',
        'customer_id',
        'paid_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public static function generateNota()
    {
        $today = now()->format('dmY');
        $prefix = "NOTABRG{$today}";

        // Ambil nomor nota terakhir hari ini
        $lastNota = self::whereDate('created_at', today())
            ->orderByDesc('id')
            ->value('nomor_nota');

        if ($lastNota) {
            // Ambil 6 digit terakhir sebagai nomor urut
            $lastNumber = (int) substr($lastNota, -6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
