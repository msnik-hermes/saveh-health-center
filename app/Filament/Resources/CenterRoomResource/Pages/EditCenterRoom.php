<?php

namespace App\Filament\Resources\CenterRoomResource\Pages;

use App\Filament\Resources\CenterRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterRoom extends EditRecord
{
    protected static string $resource = CenterRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
