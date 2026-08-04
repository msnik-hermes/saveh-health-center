<?php

namespace App\Filament\Resources\VaccineDrugResource\Pages;

use App\Filament\Resources\VaccineDrugResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVaccineDrug extends EditRecord
{
    protected static string $resource = VaccineDrugResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
