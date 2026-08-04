<?php

namespace App\Filament\Resources\SuicideStatisticResource\Pages;

use App\Filament\Resources\SuicideStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuicideStatistics extends ListRecords
{
    protected static string $resource = SuicideStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
