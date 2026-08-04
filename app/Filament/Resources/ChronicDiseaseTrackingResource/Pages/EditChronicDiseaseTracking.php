<?php

namespace App\Filament\Resources\ChronicDiseaseTrackingResource\Pages;

use App\Filament\Resources\ChronicDiseaseTrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChronicDiseaseTracking extends EditRecord
{
    protected static string $resource = ChronicDiseaseTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
