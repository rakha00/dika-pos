<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\DetailTransaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();

        // 1. Pendapatan Hari Ini
        $revenueToday = Transaction::whereDate('created_at', $today)->sum('total_price');

        // 2. Jumlah Transaksi Hari Ini
        $transactionsTodayCount = Transaction::whereDate('created_at', $today)->count();

        // 3. Rata-rata Transaksi
        $averageTransaction = ($transactionsTodayCount > 0) ? $revenueToday / $transactionsTodayCount : 0;

        // 4. Menu Terjual Hari Ini
        $itemsSoldToday = DetailTransaction::whereHas('transaction', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })->sum('quantity');

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($revenueToday))
                ->description('Total penjualan hari ini')
                ->color('success'),
            Stat::make('Transaksi Hari Ini', $transactionsTodayCount)
                ->description('Jumlah struk penjualan')
                ->color('info'),
            Stat::make('Rata-rata Transaksi', 'Rp ' . number_format($averageTransaction))
                ->description('Rata-rata belanja per struk')
                ->color('warning'),
            Stat::make('Menu Terjual Hari Ini', $itemsSoldToday)
                ->description('Total item yang terjual')
                ->color('primary'),
        ];
    }
}
