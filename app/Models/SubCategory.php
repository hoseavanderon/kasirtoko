<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'nama',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
