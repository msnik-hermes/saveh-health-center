<?php

namespace App\Filament\Resources\UnitAccessRestrictionResource\Pages;

use App\Filament\Resources\UnitAccessRestrictionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitAccessRestrictions extends ListRecords
{
    protected static string $resource = UnitAccessRestrictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
