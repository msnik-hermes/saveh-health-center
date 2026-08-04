<?php

namespace App\Filament\Resources\OccupationalExaminationResource\Pages;

use App\Filament\Resources\OccupationalExaminationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOccupationalExaminations extends ListRecords
{
    protected static string $resource = OccupationalExaminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
