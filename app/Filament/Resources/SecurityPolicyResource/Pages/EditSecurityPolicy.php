<?php

namespace App\Filament\Resources\SecurityPolicyResource\Pages;

use App\Filament\Resources\SecurityPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecurityPolicy extends EditRecord
{
    protected static string $resource = SecurityPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
