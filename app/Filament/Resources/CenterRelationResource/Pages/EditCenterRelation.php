<?php

namespace App\Filament\Resources\CenterRelationResource\Pages;

use App\Filament\Resources\CenterRelationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCenterRelation extends EditRecord
{
    protected static string $resource = CenterRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
