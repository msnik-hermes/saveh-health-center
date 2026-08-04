<?php

namespace App\Filament\Resources\ManagerAccessLevelResource\Pages;

use App\Filament\Resources\ManagerAccessLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManagerAccessLevels extends ListRecords
{
    protected static string $resource = ManagerAccessLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
