<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomOptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'customOptions';

    protected static ?string $title = 'Opsi Kustom Tambahan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category')
                    ->label('Kategori Opsi')
                    ->helperText('Contoh: Level Pedas, Ukuran, Topping')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('value')
                    ->label('Nama Opsi')
                    ->helperText('Contoh: Level 1, Large, Keju Mozarella')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('additional_price')
                    ->label('Tambahan Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0)
                    ->required(),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori Opsi'),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nama Opsi'),
                Tables\Columns\TextColumn::make('additional_price')
                    ->label('Tambahan Harga')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
