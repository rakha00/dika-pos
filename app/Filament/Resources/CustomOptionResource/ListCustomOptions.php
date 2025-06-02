<?php

namespace App\Filament\Resources\CustomOptionResource\Pages;

use App\Filament\Resources\CustomOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomOptions extends ListRecords
{
    protected static string $resource = CustomOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
