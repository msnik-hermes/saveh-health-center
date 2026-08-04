<?php

namespace App\Filament\Resources\VehicleTripResource\Pages;

use App\Filament\Resources\VehicleTripResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleTrips extends ListRecords
{
    protected static string $resource = VehicleTripResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
