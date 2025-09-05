<?php

namespace App\Filament\Resources\DigitalTransactionResource\Pages;

use App\Filament\Resources\DigitalTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDigitalTransaction extends CreateRecord
{
    protected static string $resource = DigitalTransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
