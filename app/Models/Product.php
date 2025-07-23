<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_produk',
        'barcode',
        'id_kategori',
        'id_sub_kategory',
        'id_brand',
        'modal',
        'jual',
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubCategory::class, 'id_sub_kategory');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }
}
