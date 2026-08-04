<?php

namespace App\Filament\Resources\YouthHealthResource\Pages;

use App\Filament\Resources\YouthHealthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYouthHealths extends ListRecords
{
    protected static string $resource = YouthHealthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
