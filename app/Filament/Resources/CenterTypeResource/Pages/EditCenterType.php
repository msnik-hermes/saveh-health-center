<?php

namespace App\Filament\Resources\CenterTypeResource\Pages;

use App\Filament\Resources\CenterTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterType extends EditRecord
{
    protected static string $resource = CenterTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
