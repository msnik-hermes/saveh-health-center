<?php

namespace App\Filament\Resources\StaffTransferResource\Pages;

use App\Filament\Resources\StaffTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffTransfers extends ListRecords
{
    protected static string $resource = StaffTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
