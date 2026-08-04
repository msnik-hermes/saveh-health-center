<?php

namespace App\Filament\Resources\CenterRelationResource\Pages;

use App\Filament\Resources\CenterRelationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCenterRelations extends ListRecords
{
    protected static string $resource = CenterRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
