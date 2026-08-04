<?php

namespace App\Filament\Resources\CenterUtilityResource\Pages;

use App\Filament\Resources\CenterUtilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterUtility extends EditRecord
{
    protected static string $resource = CenterUtilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
