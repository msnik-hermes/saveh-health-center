<?php

namespace App\Filament\Resources\CenterClassificationResource\Pages;

use App\Filament\Resources\CenterClassificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCenterClassifications extends ListRecords
{
    protected static string $resource = CenterClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
