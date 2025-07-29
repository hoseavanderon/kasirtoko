<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_produk',
        'barcode',
        'category_id',
        'sub_category_id',
        'brand_id',
        'modal',
        'jual',
        'minimal_stok',
        'user_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function attributeValues()
    {
        return $this->hasMany(\App\Models\ProductAttributeValue::class, 'product_id');
    }

    public function getTotalStokAttribute()
    {
        return $this->attributeValues()->sum('stok');
    }

    public function getBarcodeImageAttribute()
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeData = $generator->getBarcode($this->barcode, $generator::TYPE_CODE_39);

        return 'data:image/png;base64,' . base64_encode($barcodeData);
    }
}
