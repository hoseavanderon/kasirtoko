<?php

namespace App\Filament\Resources\PembukuanResource\Pages;

use App\Filament\Resources\PembukuanResource;
use App\Filament\Widgets\SisaSaldo;
use App\Filament\Widgets\PemasukanPengeluaranChart;
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
    
    // Metode ini menentukan widget yang akan ditampilkan.
    protected function getHeaderWidgets(): array
    {
        return [
            SisaSaldo::class,
            PemasukanPengeluaranChart::class,
        ];
    }

    // Metode ini menentukan tata letak kolom grid. 
    // Dengan 'default' => 2, kedua widget akan selalu berdampingan.
    public function getHeaderWidgetsColumns(): array
    {
        return [
            'default' => 2,
        ];
    }
}
