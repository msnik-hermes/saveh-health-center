<?php

namespace App\Filament\Resources\CenterTypeResource\Pages;

use App\Filament\Resources\CenterTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCenterTypes extends ListRecords
{
    protected static string $resource = CenterTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
