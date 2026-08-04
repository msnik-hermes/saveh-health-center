<?php

namespace App\Filament\Resources\MaternalHealthResource\Pages;

use App\Filament\Resources\MaternalHealthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaternalHealths extends ListRecords
{
    protected static string $resource = MaternalHealthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
