<?php

namespace App\Filament\Resources\FuelRecordResource\Pages;

use App\Filament\Resources\FuelRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFuelRecords extends ListRecords
{
    protected static string $resource = FuelRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
