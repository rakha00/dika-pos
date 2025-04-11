<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

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
