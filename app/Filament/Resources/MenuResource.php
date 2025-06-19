<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Menu';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Informasi Menu')
                        ->description('Isi detail dasar dari menu.')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required()->maxLength(100),
                                    Forms\Components\Select::make('category')
                                        ->label('Kategori')
                                        ->options(
                                            Menu::query()->select('category')->distinct()->pluck('category', 'category')
                                        )
                                        ->required()
                                        ->searchable()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Nama Kategori Baru')
                                                ->required()
                                                ->maxLength(50),
                                        ])
                                        ->createOptionUsing(function (array $data): string {
                                            $newCategory = $data['name'];
                                            $formattedCategory = Str::title($newCategory);
                                            return $formattedCategory;
                                        }),

                                    Forms\Components\Textarea::make('description')
                                        ->maxLength(255)->columnSpanFull(),
                                ])->columns(2),

                            Forms\Components\Section::make('Harga & Stok')
                                ->schema([
                                    Forms\Components\TextInput::make('price')
                                        ->label('Harga')
                                        ->required()->numeric()->prefix('Rp'),
                                    Forms\Components\TextInput::make('stock')
                                        ->label('Stok')
                                        ->required()->numeric(),
                                    Forms\Components\Toggle::make('is_available')
                                        ->label('Tersedia untuk dijual')
                                        ->default(true),
                                ])->columns(3),

                            Forms\Components\FileUpload::make('image')
                                ->label('Gambar Menu')
                                ->image()->directory('menus')->required(),
                        ]),

                    Wizard\Step::make('Opsi Kustom Tambahan')
                        ->description('Tambahkan variasi untuk menu ini (jika ada).')
                        ->schema([
                            Repeater::make('customOptions')
                                ->label('Daftar Opsi Kustom')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('category')
                                        ->label('Kategori Opsi')
                                        ->helperText('Contoh: Level Pedas, Ukuran')
                                        ->required()->maxLength(50),
                                    Forms\Components\TextInput::make('value')
                                        ->label('Nama Opsi')
                                        ->helperText('Contoh: Level 1, Large')
                                        ->required()->maxLength(50),
                                    Forms\Components\TextInput::make('additional_price')
                                        ->label('Tambahan Harga')
                                        ->numeric()->prefix('Rp')->default(0)->required(),
                                ])
                                ->columns(3)
                                ->defaultItems(0),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')->label('Nama Menu')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge()->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('stock')->label('Stok')->sortable(),
                Tables\Columns\ToggleColumn::make('is_available')->label('Tersedia'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->multiple()
                    ->options(
                        fn(): array => Menu::query()->select('category')->distinct()->pluck('category', 'category')->all()
                    )
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Menghubungkan Relation Manager untuk ditampilkan di halaman Edit/View
    public static function getRelations(): array
    {
        return [
            RelationManagers\CustomOptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'view' => Pages\ViewMenu::route('/{record}'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
