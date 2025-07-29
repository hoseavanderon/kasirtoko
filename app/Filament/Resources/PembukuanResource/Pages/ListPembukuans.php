<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembukuans extends ListRecords
{
    protected static string $resource = PembukuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
