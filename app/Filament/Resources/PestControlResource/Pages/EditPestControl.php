<?php

namespace App\Filament\Resources\PestControlResource\Pages;

use App\Filament\Resources\PestControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPestControl extends EditRecord
{
    protected static string $resource = PestControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
