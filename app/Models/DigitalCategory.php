<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function digitalProducts()
    {
        return $this->hasMany(DigitalProduct::class, 'digital_category_id');
    }
}