<?php

namespace App\Filament\Resources\VaccineDrugDistributionResource\Pages;

use App\Filament\Resources\VaccineDrugDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVaccineDrugDistribution extends EditRecord
{
    protected static string $resource = VaccineDrugDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
