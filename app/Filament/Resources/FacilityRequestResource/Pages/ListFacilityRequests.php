<?php

namespace App\Filament\Resources\FacilityRequestResource\Pages;

use App\Filament\Resources\FacilityRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacilityRequests extends ListRecords
{
    protected static string $resource = FacilityRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
