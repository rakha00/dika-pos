<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Exports\TransactionExporter;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // INI ADALAH IMPLEMENTASI FINAL DAN YANG BENAR
            Action::make('export')
                ->label('Download Laporan Bulanan')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down') // Tambah ikon agar lebih jelas

                // Form untuk mengambil input dari user, ini tidak berubah
                ->form([
                    Forms\Components\Select::make('month')
                        ->label('Pilih Bulan')
                        ->options([
                            '1' => 'Januari',
                            '2' => 'Februari',
                            '3' => 'Maret',
                            '4' => 'April',
                            '5' => 'Mei',
                            '6' => 'Juni',
                            '7' => 'Juli',
                            '8' => 'Agustus',
                            '9' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'Desember',
                        ])->default(date('n'))->required(),
                    Forms\Components\Select::make('year')
                        ->label('Pilih Tahun')
                        ->options(function () {
                            $years = [];
                            for ($y = date('Y'); $y >= 2023; $y--) {
                                $years[$y] = $y;
                            }
                            return $years;
                        })->default(date('Y'))->required(),
                ])

                // ->action() adalah tempat kita menaruh logika kustom
                // Ini akan berjalan setelah form diisi dan tombol "Export" ditekan
                ->action(function (array $data) {
                    $month = (int) $data['month'];
                    $year = (int) $data['year'];
                    $monthName = \Carbon\Carbon::createFromDate($year, $month)->translatedFormat('F');
                    $fileName = "Laporan Transaksi - {$monthName} {$year}.xlsx";

                    // Buat instance exporter kita dan picu download menggunakan Facade Excel
                    // Ini akan mengembalikan response download ke browser
                    return Excel::download(new TransactionExporter($month, $year), $fileName);
                }),
        ];
    }
}
