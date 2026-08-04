<?php

namespace App\Filament\Resources\OfficialCorrespondenceResource\Pages;

use App\Filament\Resources\OfficialCorrespondenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfficialCorrespondence extends EditRecord
{
    protected static string $resource = OfficialCorrespondenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
