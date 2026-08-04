<?php

namespace App\Filament\Resources\ChronicDiseaseTrackingResource\Pages;

use App\Filament\Resources\ChronicDiseaseTrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChronicDiseaseTrackings extends ListRecords
{
    protected static string $resource = ChronicDiseaseTrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
