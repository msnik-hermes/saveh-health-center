<?php

namespace App\Filament\Resources\OfficialCorrespondenceResource\Pages;

use App\Filament\Resources\OfficialCorrespondenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfficialCorrespondences extends ListRecords
{
    protected static string $resource = OfficialCorrespondenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
