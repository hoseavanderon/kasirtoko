<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePembukuan extends CreateRecord
{
    protected static string $resource = PembukuanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
