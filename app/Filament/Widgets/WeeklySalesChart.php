<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class WeeklySalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan 7 Hari Terakhir';
    protected static ?int $sort = 2;

    // TAMBAHKAN BARIS INI
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Tanggal hari ini, 18 Juni 2025 (karena current time adalah 19 Juni, 7 hari lalu adalah 12 Juni)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Transaction::whereDate('created_at', $date)->sum('total_price');

            $data[] = $sales;
            $labels[] = $date->format('D, d M'); // Format: Sun, 16 Jun
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
