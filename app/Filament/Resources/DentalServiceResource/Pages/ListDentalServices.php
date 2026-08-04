<?php

namespace App\Filament\Resources\DentalServiceResource\Pages;

use App\Filament\Resources\DentalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDentalServices extends ListRecords
{
    protected static string $resource = DentalServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
