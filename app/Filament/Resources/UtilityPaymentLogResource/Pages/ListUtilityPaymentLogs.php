<?php

namespace App\Filament\Resources\UtilityPaymentLogResource\Pages;

use App\Filament\Resources\UtilityPaymentLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUtilityPaymentLogs extends ListRecords
{
    protected static string $resource = UtilityPaymentLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
