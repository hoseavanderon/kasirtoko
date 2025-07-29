<?php

namespace App\Filament\Resources\CategoryPembukuanResource\Pages;

use App\Filament\Resources\CategoryPembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryPembukuans extends ListRecords
{
    protected static string $resource = CategoryPembukuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
