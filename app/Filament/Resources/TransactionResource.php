<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\DailyReport;
use App\Models\Menu;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id_user')
                    ->default(fn() => Auth::id()),

                Forms\Components\DateTimePicker::make('transaction_date')
                    ->label('Waktu Transaksi')
                    ->default(now())
                    ->disabled(),

                Forms\Components\TextInput::make('total_price')
                    ->label('Total Harga')
                    ->prefix('Rp')
                    ->default(0)
                    ->reactive(),

                Forms\Components\Repeater::make('detail_transactions')
                    ->label('Detail Menu')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('id_menu')
                            ->label('Menu')
                            ->options(Menu::pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $harga = Menu::find($state)?->price ?? 0;
                                $set('unit_price', $harga);
                            }),

                        Forms\Components\TextInput::make('unit_price')
                            ->label('Harga Satuan')
                            ->prefix('Rp')
                            ->disabled(),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $subtotal = ($get('harga_satuan') ?? 0) * $state;
                                $set('subtotal', $subtotal);
                            }),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->readOnly()
                    ])
                    ->columns(3)
            ]);
    }

    // protected function afterCreate(): void
    // {
    //     $totalHarga = 0;

    //     foreach ($this->record->detail_transactions as $detail) {
    //         $menu = $detail->menu;

    //         if ($menu->stok < $detail->jumlah) {
    //             throw ValidationException::withMessages([
    //                 'detail_transactions' => "Stok untuk {$menu->nama_menu} tidak cukup.",
    //             ]);
    //         }

    //         $menu->stok -= $detail->jumlah;
    //         $menu->save();

    //         $totalHarga += $detail->subtotal;
    //     }

    //     $this->record->update(['total_price' => $totalHarga]);

    //     $tanggal = now()->toDateString();

    //     $dailyReport = DailyReport::firstOrCreate(
    //         ['date' => $tanggal],
    //         ['total_transactions' => 0, 'total_sales' => 0]
    //     );

    //     $dailyReport->increment('total_transactions');
    //     $dailyReport->increment('total_sales', $totalHarga);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Kasir')
                    ->searchable(),

                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Waktu')
                    ->dateTime('d M Y - H:i'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-receipt-refund';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Transaksi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Transaksi';
    }
}
