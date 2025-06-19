<?php

namespace App\Exports; // <-- Pastikan namespace ini sesuai dengan lokasi file Anda

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExporter implements FromQuery, WithHeadings, WithMapping, WithEvents, WithCustomStartCell, ShouldAutoSize
{
    protected int $month;
    protected int $year;

    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        // Query sudah difilter berdasarkan status 'completed'
        return Transaction::query()
            ->where('status', 'completed')
            ->whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year);
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Pelanggan',
            'Kasir',
            'Total Harga',
            'Waktu Transaksi',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_id,
            $transaction->customer_name,
            $transaction->user->name,
            'Rp ' . number_format($transaction->total_price, 0, ',', '.'),
            Carbon::parse($transaction->created_at)->format('d-m-Y H:i:s'),
        ];
    }

    /**
     * Method ini memberitahu Excel untuk memulai tabel data dari sel A7
     */
    public function startCell(): string
    {
        return 'A7';
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $monthName = Carbon::createFromDate($this->year, $this->month)->translatedFormat('F');
                $queryClone = clone $this->query();
                $totalRevenue = $queryClone->sum('total_price');
                $totalTransactions = $queryClone->count();

                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true)->setSize(16);

                $event->sheet->getDelegate()->setCellValue('A1', 'Laporan Penjualan Bulanan');
                $event->sheet->getDelegate()->setCellValue('A3', 'Periode');
                $event->sheet->getDelegate()->setCellValue('B3', ': ' . $monthName . ' ' . $this->year);
                $event->sheet->getDelegate()->setCellValue('A4', 'Total Pendapatan (Completed)');
                $event->sheet->getDelegate()->setCellValue('B4', ': Rp ' . number_format($totalRevenue, 0, ',', '.'));
                $event->sheet->getDelegate()->setCellValue('A5', 'Jumlah Transaksi (Completed)');
                $event->sheet->getDelegate()->setCellValue('B5', ': ' . $totalTransactions . ' Transaksi');
            },
        ];
    }
}
