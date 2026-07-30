<?php

namespace App\Filament\Resources\PregnantWomanResource\Pages;

use App\Filament\Resources\PregnantWomanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPregnantWomen extends ListRecords
{
    protected static string $resource = PregnantWomanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
