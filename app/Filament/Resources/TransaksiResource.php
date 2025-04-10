<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id_user')
                    ->default(fn() => Auth::id()),

                Forms\Components\Repeater::make('detail_transaksis')
                    ->label('Daftar Menu')
                    ->relationship()
                    ->reactive() // penting: biar bisa trigger state luar (total_harga)
                    ->schema([
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $menuId = $get('id_menu');
                                $harga = \App\Models\Menu::find($menuId)?->harga ?? 0;
                                $subtotal = $harga * (int)$state;
                                $set('subtotal', $subtotal);

                                self::hitungTotal($set, $get);

                                // Hitung ulang total_harga di sini
                                $parentItems = $get('../../detail_transaksis') ?? [];
                                $index = $get('../../index');
                                $parentItems[$index]['subtotal'] = $subtotal;
                                $total = collect($parentItems)->sum(fn($item) => $item['subtotal'] ?? 0);
                                $set('../../total_harga', $total);
                            }),

                        Forms\Components\Select::make('id_menu')
                            ->label('Menu')
                            ->relationship('menu', 'nama_menu')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $jumlah = (int) $get('jumlah');
                                $harga = \App\Models\Menu::find($state)?->harga ?? 0;
                                $subtotal = $harga * $jumlah;
                                $set('subtotal', $subtotal);

                                self::hitungTotal($set, $get);

                                // Hitung ulang total_harga di sini
                                $parentItems = $get('../../detail_transaksis') ?? [];
                                $index = $get('../../index');
                                $parentItems[$index]['subtotal'] = $subtotal;
                                $total = collect($parentItems)->sum(fn($item) => $item['subtotal'] ?? 0);
                                $set('../../total_harga', $total);
                            }),

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->readOnly()
                            ->label('Subtotal'),
                    ])
                    ->columns(3),

                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->readOnly()
                    ->default(0)
                    ->reactive()
                    ->afterStateHydrated(function (callable $set, $get) {
                        $items = $get('detail_transaksis') ?? [];
                        $total = collect($items)->sum(fn($item) => $item['subtotal'] ?? 0);
                        $set('total_harga', $total);
                    }),
            ]);
    }

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

                Tables\Columns\TextColumn::make('waktu_transaksi')
                    ->label('Waktu')
                    ->dateTime('d M Y - H:i'),

                Tables\Columns\TextColumn::make('total_harga')
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'view' => Pages\ViewTransaksi::route('/{record}'),
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

    private static function hitungTotal(callable $set, callable $get)
    {
        $items = $get('detail_transaksis') ?? [];
        $total = collect($items)->sum(fn($item) => $item['subtotal'] ?? 0);
        $set('total_harga', $total);
    }
}
