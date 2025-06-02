<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomOptionResource\Pages;
use App\Models\CustomOption;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\RelationManagers\Concerns\CanViewRecords;
use App\Filament\Resources\CustomOptionResource\RelationManagers\CustomOptionValueRelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class CustomOptionResource extends Resource
{
    protected static ?string $model = CustomOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationGroup = 'Menu Management';

    protected static ?string $slug = 'custom-options';
    protected static ?string $label = 'Custom Option';
    protected static ?string $pluralLabel = 'Custom Options';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Opsi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Option Name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomOptions::route('/'),
            'create' => Pages\CreateCustomOption::route('/create'),
            'edit' => Pages\EditCustomOption::route('/{record}/edit'),
        ];
    }
}