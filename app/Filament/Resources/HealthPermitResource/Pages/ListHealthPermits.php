<?php

namespace App\Filament\Resources\HealthPermitResource\Pages;

use App\Filament\Resources\HealthPermitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthPermits extends ListRecords
{
    protected static string $resource = HealthPermitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
