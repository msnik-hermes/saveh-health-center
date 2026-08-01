<?php

namespace App\Filament\Resources\HazardAssessmentResource\Pages;

use App\Filament\Resources\HazardAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHazardAssessment extends EditRecord
{
    protected static string $resource = HazardAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
