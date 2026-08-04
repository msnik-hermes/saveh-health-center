<?php

namespace App\Filament\Resources\ElderlyCareResource\Pages;

use App\Filament\Resources\ElderlyCareResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElderlyCares extends ListRecords
{
    protected static string $resource = ElderlyCareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
