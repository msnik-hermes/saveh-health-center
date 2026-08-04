<?php

namespace App\Filament\Resources\CenterBankAccountResource\Pages;

use App\Filament\Resources\CenterBankAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterBankAccount extends EditRecord
{
    protected static string $resource = CenterBankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
