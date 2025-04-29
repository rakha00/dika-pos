<?php

namespace App\Filament\Resources\CustomOptionResource\Pages;

use App\Filament\Resources\CustomOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomOption extends CreateRecord
{
    protected static string $resource = CustomOptionResource::class;
}
