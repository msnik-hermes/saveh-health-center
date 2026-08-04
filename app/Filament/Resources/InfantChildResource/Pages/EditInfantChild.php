<?php

namespace App\Filament\Resources\InfantChildResource\Pages;

use App\Filament\Resources\InfantChildResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfantChild extends EditRecord
{
    protected static string $resource = InfantChildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
