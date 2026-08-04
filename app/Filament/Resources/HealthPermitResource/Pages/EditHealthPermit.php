<?php

namespace App\Filament\Resources\HealthPermitResource\Pages;

use App\Filament\Resources\HealthPermitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthPermit extends EditRecord
{
    protected static string $resource = HealthPermitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
