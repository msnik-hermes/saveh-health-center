<?php

namespace App\Filament\Resources\EarlyRetirementCaseResource\Pages;

use App\Filament\Resources\EarlyRetirementCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEarlyRetirementCase extends EditRecord
{
    protected static string $resource = EarlyRetirementCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
