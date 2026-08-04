<?php

namespace App\Filament\Resources\StaffTransferResource\Pages;

use App\Filament\Resources\StaffTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffTransfer extends EditRecord
{
    protected static string $resource = StaffTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
