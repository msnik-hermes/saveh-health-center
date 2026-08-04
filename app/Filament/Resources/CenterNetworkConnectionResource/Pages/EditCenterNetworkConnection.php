<?php

namespace App\Filament\Resources\CenterNetworkConnectionResource\Pages;

use App\Filament\Resources\CenterNetworkConnectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterNetworkConnection extends EditRecord
{
    protected static string $resource = CenterNetworkConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
