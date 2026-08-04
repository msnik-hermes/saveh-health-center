<?php

namespace App\Filament\Resources\AccessChangeResource\Pages;

use App\Filament\Resources\AccessChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessChange extends EditRecord
{
    protected static string $resource = AccessChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
