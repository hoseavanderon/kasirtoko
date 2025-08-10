<?php

namespace App\Filament\Widgets;

use App\Models\Pembukuan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SisaSaldo extends BaseWidget
{
    protected static ?int $sort = 1; 
    protected int | string | array $columnSpan = 2;

    protected function getCards(): array
    {
        $totalIn = Pembukuan::where('type', 'IN')->sum('nominal');
        $totalOut = Pembukuan::where('type', 'OUT')->sum('nominal');
        $saldo = $totalIn - $totalOut;

        return [
            Card::make('Sisa Saldo', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->description('Total Uang Toko')
                ->descriptionIcon($saldo >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($saldo >= 0 ? 'success' : 'danger'),
        ];
    }
}
