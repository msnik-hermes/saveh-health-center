<?php

namespace App\Filament\Resources\MedicalEquipmentResource\Pages;

use App\Filament\Resources\MedicalEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicalEquipments extends ListRecords
{
    protected static string $resource = MedicalEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
