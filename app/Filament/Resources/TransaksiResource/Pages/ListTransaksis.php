<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(), // tombol "Tambah Transaksi"
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')->label('Kasir'),
            Tables\Columns\TextColumn::make('total')->money('IDR', true),
            Tables\Columns\TextColumn::make('status')->badge()->color('success'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y, H:i'),
        ];
    }
}
