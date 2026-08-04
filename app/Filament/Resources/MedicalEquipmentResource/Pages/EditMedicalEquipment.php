<?php

namespace App\Filament\Resources\MedicalEquipmentResource\Pages;

use App\Filament\Resources\MedicalEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicalEquipment extends EditRecord
{
    protected static string $resource = MedicalEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
