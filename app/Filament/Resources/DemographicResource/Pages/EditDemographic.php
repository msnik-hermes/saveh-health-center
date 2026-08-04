<?php

namespace App\Filament\Resources\DemographicResource\Pages;

use App\Filament\Resources\DemographicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemographic extends EditRecord
{
    protected static string $resource = DemographicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
