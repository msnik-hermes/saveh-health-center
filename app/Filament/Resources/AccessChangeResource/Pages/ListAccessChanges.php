<?php

namespace App\Filament\Resources\AccessChangeResource\Pages;

use App\Filament\Resources\AccessChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessChanges extends ListRecords
{
    protected static string $resource = AccessChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
