<?php

namespace App\Filament\Resources\ManagerAccessLevelResource\Pages;

use App\Filament\Resources\ManagerAccessLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManagerAccessLevel extends EditRecord
{
    protected static string $resource = ManagerAccessLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
