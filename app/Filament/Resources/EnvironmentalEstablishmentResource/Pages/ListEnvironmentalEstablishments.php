<?php

namespace App\Filament\Resources\EnvironmentalEstablishmentResource\Pages;

use App\Filament\Resources\EnvironmentalEstablishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnvironmentalEstablishments extends ListRecords
{
    protected static string $resource = EnvironmentalEstablishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
