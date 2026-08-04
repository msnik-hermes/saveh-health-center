<?php

namespace App\Filament\Resources\OccupationalExaminationResource\Pages;

use App\Filament\Resources\OccupationalExaminationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOccupationalExamination extends EditRecord
{
    protected static string $resource = OccupationalExaminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
