<?php

namespace App\Filament\Resources\ThyroidScreeningResource\Pages;

use App\Filament\Resources\ThyroidScreeningResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThyroidScreening extends EditRecord
{
    protected static string $resource = ThyroidScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
