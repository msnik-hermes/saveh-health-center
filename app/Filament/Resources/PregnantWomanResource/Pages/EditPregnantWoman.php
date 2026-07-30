<?php

namespace App\Filament\Resources\PregnantWomanResource\Pages;

use App\Filament\Resources\PregnantWomanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPregnantWoman extends EditRecord
{
    protected static string $resource = PregnantWomanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
