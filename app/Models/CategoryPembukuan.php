<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPembukuan extends Model
{
    protected $table = 'category_pembukuan';

    protected $fillable = [
        'category_pembukuan',
    ];
    
    public function pembukuans()
    {
        return $this->hasMany(Pembukuan::class);
    }
}
