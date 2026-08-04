<?php

namespace App\Filament\Resources\ThyroidScreeningResource\Pages;

use App\Filament\Resources\ThyroidScreeningResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThyroidScreenings extends ListRecords
{
    protected static string $resource = ThyroidScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
