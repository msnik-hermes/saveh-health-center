<?php

namespace App\Filament\Resources\SupplyInventoryResource\Pages;

use App\Filament\Resources\SupplyInventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplyInventory extends EditRecord
{
    protected static string $resource = SupplyInventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
