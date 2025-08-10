<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'kode_category',
        'nama',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
