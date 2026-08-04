<?php

namespace App\Filament\Resources\TrainingServiceRecordResource\Pages;

use App\Filament\Resources\TrainingServiceRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingServiceRecords extends ListRecords
{
    protected static string $resource = TrainingServiceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
