<?php

namespace App\Filament\Resources\FamilyPlanningResource\Pages;

use App\Filament\Resources\FamilyPlanningResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyPlannings extends ListRecords
{
    protected static string $resource = FamilyPlanningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
