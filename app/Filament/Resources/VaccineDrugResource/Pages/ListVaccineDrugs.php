<?php

namespace App\Filament\Resources\VaccineDrugResource\Pages;

use App\Filament\Resources\VaccineDrugResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVaccineDrugs extends ListRecords
{
    protected static string $resource = VaccineDrugResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
