<?php

namespace App\Filament\Resources\CenterPhoneLineResource\Pages;

use App\Filament\Resources\CenterPhoneLineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCenterPhoneLines extends ListRecords
{
    protected static string $resource = CenterPhoneLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
