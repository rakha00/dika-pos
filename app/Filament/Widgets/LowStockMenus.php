<?php
namespace App\Filament\Widgets;

use App\Models\Menu;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockMenus extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Menu::query()->where('stock', '<', 10)->orderBy('stock', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Menu'),
                Tables\Columns\TextColumn::make('stock')->label('Sisa Stok')->badge()->color('danger'),
            ])
            ->paginated(false);
    }
}
