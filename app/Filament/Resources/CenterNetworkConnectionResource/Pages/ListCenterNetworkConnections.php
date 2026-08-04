<?php

namespace App\Filament\Resources\CenterNetworkConnectionResource\Pages;

use App\Filament\Resources\CenterNetworkConnectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCenterNetworkConnections extends ListRecords
{
    protected static string $resource = CenterNetworkConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
