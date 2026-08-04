<?php

namespace App\Filament\Resources\FamilyPlanningResource\Pages;

use App\Filament\Resources\FamilyPlanningResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyPlanning extends EditRecord
{
    protected static string $resource = FamilyPlanningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
