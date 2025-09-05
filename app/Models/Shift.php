<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'user_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
