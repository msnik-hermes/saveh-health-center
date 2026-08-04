<?php

namespace App\Filament\Resources\SuicideStatisticResource\Pages;

use App\Filament\Resources\SuicideStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuicideStatistic extends EditRecord
{
    protected static string $resource = SuicideStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
