<?php

namespace App\Filament\Resources\DentalServiceResource\Pages;

use App\Filament\Resources\DentalServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDentalService extends EditRecord
{
    protected static string $resource = DentalServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
