<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPembukuan extends EditRecord
{
    protected static string $resource = PembukuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!isset($this->record->id)) {
            $data['user_id'] = Auth::id();
        }
        return $data;
    }

}
