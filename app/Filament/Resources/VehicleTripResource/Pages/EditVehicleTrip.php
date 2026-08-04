<?php

namespace App\Filament\Resources\VehicleTripResource\Pages;

use App\Filament\Resources\VehicleTripResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleTrip extends EditRecord
{
    protected static string $resource = VehicleTripResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
