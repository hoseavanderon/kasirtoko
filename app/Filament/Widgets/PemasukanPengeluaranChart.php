<?php

namespace App\Filament\Widgets;

use App\Models\Pembukuan;
use Filament\Widgets\ChartWidget;

class PemasukanPengeluaranChart extends ChartWidget
{
    protected static ?string $heading = 'Pemasukan vs Pengeluaran';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 2;

    protected function getType(): string
    {
        return 'bar'; 
    }

    protected function getData(): array
    {
        $pemasukan = Pembukuan::where('type', 'IN')->sum('nominal');
        $pengeluaran = Pembukuan::where('type', 'OUT')->sum('nominal');

        return [
            'datasets' => [
                [
                    'label' => 'Total Pembukuan',
                    'data' => [$pemasukan, $pengeluaran],
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                    ],
                    'borderColor' => [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Pemasukan', 'Pengeluaran'],
        ];
    }
}
