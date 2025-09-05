<?php

namespace App\Filament\Resources\ShiftResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\ShiftResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShift extends CreateRecord
{
    protected static string $resource = ShiftResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Isi user_id otomatis dari user login
        return $data;
    }
}
