<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use App\Models\Pembukuan;
use Filament\Resources\Pages\CreateRecord;

class CreatePembukuan extends CreateRecord
{
    protected static string $resource = PembukuanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $lastSaldo = Pembukuan::latest()->first()?->sisa_saldo ?? 0;

        $data['sisa_saldo'] = $data['type'] === 'IN'
            ? $lastSaldo + $data['nominal']
            : $lastSaldo - $data['nominal'];

        return $data;
    }
}
