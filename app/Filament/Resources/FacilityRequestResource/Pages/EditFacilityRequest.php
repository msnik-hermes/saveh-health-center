<?php

namespace App\Filament\Resources\FacilityRequestResource\Pages;

use App\Filament\Resources\FacilityRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFacilityRequest extends EditRecord
{
    protected static string $resource = FacilityRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
