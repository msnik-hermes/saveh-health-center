<?php

namespace App\Filament\Resources\VaccineDrugDistributionResource\Pages;

use App\Filament\Resources\VaccineDrugDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVaccineDrugDistributions extends ListRecords
{
    protected static string $resource = VaccineDrugDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
