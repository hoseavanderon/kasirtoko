<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembukuan extends EditRecord
{
    protected static string $resource = PembukuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
