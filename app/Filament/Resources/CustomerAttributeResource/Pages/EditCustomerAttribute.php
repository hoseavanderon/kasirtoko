<?php

namespace App\Filament\Resources\CustomerAttributeResource\Pages;

use App\Filament\Resources\CustomerAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerAttribute extends EditRecord
{
    protected static string $resource = CustomerAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
