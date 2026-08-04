<?php

namespace App\Filament\Resources\YouthHealthResource\Pages;

use App\Filament\Resources\YouthHealthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYouthHealth extends EditRecord
{
    protected static string $resource = YouthHealthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
