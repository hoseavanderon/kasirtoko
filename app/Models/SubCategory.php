<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id_kategori', 'nama'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}