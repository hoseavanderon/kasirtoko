<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $category = \App\Models\Category::find($data['category_id']);
        $prefix = $category->kode_category ?? 'XXX';
        $lastId = \App\Models\Product::where('category_id', $category->id)->count() + 1;
        $barcode = $prefix . str_pad($lastId, 8, '0', STR_PAD_LEFT);
        $data['barcode'] = $barcode;
        $data['user_id'] = Auth::id();

        return $data;
    }
}
