<?php

namespace App\Filament\Resources\ImmunizationRecordResource\Pages;

use App\Filament\Resources\ImmunizationRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImmunizationRecord extends EditRecord
{
    protected static string $resource = ImmunizationRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
