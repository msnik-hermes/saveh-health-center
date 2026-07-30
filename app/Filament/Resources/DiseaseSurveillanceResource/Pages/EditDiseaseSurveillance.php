<?php

namespace App\Filament\Resources\DiseaseSurveillanceResource\Pages;

use App\Filament\Resources\DiseaseSurveillanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiseaseSurveillance extends EditRecord
{
    protected static string $resource = DiseaseSurveillanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
