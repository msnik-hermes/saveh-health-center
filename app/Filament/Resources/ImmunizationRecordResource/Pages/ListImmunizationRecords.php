<?php

namespace App\Filament\Resources\ImmunizationRecordResource\Pages;

use App\Filament\Resources\ImmunizationRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImmunizationRecords extends ListRecords
{
    protected static string $resource = ImmunizationRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
