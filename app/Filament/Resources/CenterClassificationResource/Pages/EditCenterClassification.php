<?php

namespace App\Filament\Resources\CenterClassificationResource\Pages;

use App\Filament\Resources\CenterClassificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterClassification extends EditRecord
{
    protected static string $resource = CenterClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
