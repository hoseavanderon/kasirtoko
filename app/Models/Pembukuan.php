<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembukuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembukuan';

    protected $fillable = [
        'deskripsi',
        'type',
        'nominal',
        'sisa_saldo',
        'user_id',
        'category_pembukuan_id'
    ];

    public function categoryPembukuan()
    {
        return $this->belongsTo(CategoryPembukuan::class);
    }
}