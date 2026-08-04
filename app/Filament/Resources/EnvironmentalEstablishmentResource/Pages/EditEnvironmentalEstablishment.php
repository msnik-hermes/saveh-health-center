<?php

namespace App\Filament\Resources\EnvironmentalEstablishmentResource\Pages;

use App\Filament\Resources\EnvironmentalEstablishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnvironmentalEstablishment extends EditRecord
{
    protected static string $resource = EnvironmentalEstablishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
