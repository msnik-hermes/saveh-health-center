<?php

namespace App\Filament\Resources\MaternalHealthResource\Pages;

use App\Filament\Resources\MaternalHealthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaternalHealth extends EditRecord
{
    protected static string $resource = MaternalHealthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
