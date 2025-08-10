<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembukuan extends Model
{
    protected $fillable = [
        'deskripsi',
        'type',
        'nominal',
        'user_id',
        'category_pembukuan_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryPembukuan()
    {
        return $this->belongsTo(CategoryPembukuan::class);
    }
}
