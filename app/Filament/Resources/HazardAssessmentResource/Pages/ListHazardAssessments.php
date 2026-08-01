<?php

namespace App\Filament\Resources\HazardAssessmentResource\Pages;

use App\Filament\Resources\HazardAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHazardAssessments extends ListRecords
{
    protected static string $resource = HazardAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
