<?php

namespace App\Filament\Resources\VehicleRequestResource\Pages;

use App\Filament\Resources\VehicleRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleRequest extends EditRecord
{
    protected static string $resource = VehicleRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
