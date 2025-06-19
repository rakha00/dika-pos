<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists; // <-- Import Infolist
use Filament\Infolists\Infolist; // <-- Import Infolist

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Laporan';

    // Admin tidak membuat transaksi manual, jadi kita sembunyikan tombol 'Create'
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        // Form ini hanya untuk edit, misal mengubah status
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('ID Transaksi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name') // Ambil dari relasi
                    ->label('Kasir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Transaksi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(), // Jika admin boleh ubah status
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Ini adalah bagian untuk halaman Detail (View).
     * Kita akan menampilkan semua informasi transaksi di sini.
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Infolists\Components\Grid::make(3)->schema([
                            Infolists\Components\TextEntry::make('transaction_id')->label('ID Transaksi'),
                            Infolists\Components\TextEntry::make('customer_name')->label('Nama Pelanggan'),
                            Infolists\Components\TextEntry::make('user.name')->label('Kasir'),
                            Infolists\Components\TextEntry::make('created_at')->dateTime()->label('Waktu'),
                            Infolists\Components\TextEntry::make('status')->badge()->colors([
                                'warning' => 'pending',
                                'success' => 'completed',
                                'danger' => 'cancelled',
                            ]),
                        ]),
                    ]),
                Infolists\Components\Section::make('Detail Item')
                    ->schema([
                        // Ini akan menampilkan daftar item dari detail_transactions
                        Infolists\Components\RepeatableEntry::make('detailTransactions')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('menu.name')->label('Menu')->weight('bold'),
                                Infolists\Components\TextEntry::make('quantity')->label('Jumlah'),
                                Infolists\Components\TextEntry::make('subtotal')->label('Subtotal')->money('IDR'),
                            ])->columns(3),
                    ]),
                Infolists\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Infolists\Components\Grid::make(3)->schema([
                            Infolists\Components\TextEntry::make('total_price')->money('IDR')->label('Total Harga'),
                            Infolists\Components\TextEntry::make('cash_amount')->money('IDR')->label('Uang Tunai'),
                            Infolists\Components\TextEntry::make('change_amount')
                                ->label('Kembalian')
                                ->money('IDR')
                                ->getStateUsing(function (Transaction $record) {
                                    return $record->cash_amount - $record->total_price;
                                }),
                        ]),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            // 'create' => Pages\CreateTransaction::route('/create'), // kita disable
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
