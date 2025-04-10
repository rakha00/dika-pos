<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Components\{Repeater, Select, TextInput, DateTimePicker};
use Filament\Forms\Form;
use App\Models\Menu;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\LaporanHarian;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('waktu_transaksi')
                    ->label('Waktu Transaksi')
                    ->default(now())
                    ->disabled(),

                TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->prefix('Rp')
                    ->readOnly()
                    ->reactive(),

                Repeater::make('detail_transaksis')
                    ->label('Detail Menu')
                    ->relationship()
                    ->schema([
                        Select::make('id_menu')
                            ->label('Menu')
                            ->options(Menu::pluck('nama_menu', 'id'))
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $harga = \App\Models\Menu::find($state)?->harga ?? 0;
                                $set('harga_satuan', $harga);
                            }),

                        TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->prefix('Rp')
                            ->disabled(),

                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $subtotal = ($get('harga_satuan') ?? 0) * $state;
                                $set('subtotal', $subtotal);
                            }),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->readOnly()
                    ])
                    ->columns(3)
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_user'] = Auth::id();
        $data['waktu_transaksi'] = now();
        $data['total_harga'] = 0;

        return $data;
    }

    protected function afterCreate(): void
    {
        $totalHarga = 0;

        foreach ($this->record->detail_transaksis as $detail) {
            $menu = $detail->menu;

            if ($menu->stok < $detail->jumlah) {
                throw ValidationException::withMessages([
                    'detail_transaksis' => "Stok untuk {$menu->nama_menu} tidak cukup.",
                ]);
            }

            $menu->stok -= $detail->jumlah;
            $menu->save();

            $totalHarga += $detail->subtotal;
        }

        $this->record->update(['total_harga' => $totalHarga]);

        $tanggal = now()->toDateString();

        $laporan = LaporanHarian::firstOrCreate(
            ['tanggal' => $tanggal],
            ['total_transaksi' => 0, 'total_penjualan' => 0]
        );

        $laporan->increment('total_transaksi');
        $laporan->increment('total_penjualan', $totalHarga);
    }
}
