<?php

namespace App\Filament\Resources\EnvironmentalInspectionResource\Pages;

use App\Filament\Resources\EnvironmentalInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnvironmentalInspections extends ListRecords
{
    protected static string $resource = EnvironmentalInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
