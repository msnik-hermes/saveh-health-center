<?php

namespace App\Filament\Resources\UnitAccessRestrictionResource\Pages;

use App\Filament\Resources\UnitAccessRestrictionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnitAccessRestriction extends EditRecord
{
    protected static string $resource = UnitAccessRestrictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
