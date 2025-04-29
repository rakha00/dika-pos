<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationGroup = 'Menu Management';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Menu Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->label('Menu Name'),

                    TextInput::make('category')
                        ->required()
                        ->label('Category'),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3),

                    FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->directory('menus')
                        ->imagePreviewHeight('150'),

                    TextInput::make('price')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->label('Price (in IDR)'),

                    TextInput::make('stock')
                        ->numeric()
                        ->minValue(0)
                        ->required()
                        ->label('Stock'),

                    Toggle::make('is_customizable')
                        ->label('Enable Customization')
                        ->reactive(),
                ]),

            // Conditional Custom Options
            Section::make('Customization Options')
                ->schema([
                    Select::make('customOptions')
                        ->label('Select Custom Options')
                        ->multiple()
                        ->relationship('customOptions', 'name')
                        ->visible(fn (Forms\Get $get) => $get('is_customizable') === true)
                        ->preload()
                        ->searchable(),
                ])
                ->visible(fn (Forms\Get $get) => $get('is_customizable') === true)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable(),
            
                \Filament\Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
            
                \Filament\Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->wrap(),
            
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),
            
                \Filament\Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),
            
                \Filament\Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),
            
                \Filament\Tables\Columns\IconColumn::make('is_customizable')
                    ->label('Customizable')
                    ->boolean(),
            
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y - H:i')
                    ->sortable(),
            ])        
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
                ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}