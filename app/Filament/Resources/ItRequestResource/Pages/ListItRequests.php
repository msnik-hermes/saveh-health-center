<?php

namespace App\Filament\Resources\ItRequestResource\Pages;

use App\Filament\Resources\ItRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItRequests extends ListRecords
{
    protected static string $resource = ItRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
