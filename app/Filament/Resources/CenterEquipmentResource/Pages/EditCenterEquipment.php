<?php

namespace App\Filament\Resources\CenterEquipmentResource\Pages;

use App\Filament\Resources\CenterEquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterEquipment extends EditRecord
{
    protected static string $resource = CenterEquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
