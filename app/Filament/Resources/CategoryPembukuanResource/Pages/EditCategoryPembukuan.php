<?php

namespace App\Filament\Resources\CategoryPembukuanResource\Pages;

use App\Filament\Resources\CategoryPembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryPembukuan extends EditRecord
{
    protected static string $resource = CategoryPembukuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
