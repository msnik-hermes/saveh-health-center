<?php

namespace App\Filament\Resources\FuelRecordResource\Pages;

use App\Filament\Resources\FuelRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFuelRecord extends EditRecord
{
    protected static string $resource = FuelRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
