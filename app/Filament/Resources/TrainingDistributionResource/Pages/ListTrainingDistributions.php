<?php

namespace App\Filament\Resources\TrainingDistributionResource\Pages;

use App\Filament\Resources\TrainingDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingDistributions extends ListRecords
{
    protected static string $resource = TrainingDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
