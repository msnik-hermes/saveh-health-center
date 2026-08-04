<?php

namespace App\Filament\Resources\SchoolHealthResource\Pages;

use App\Filament\Resources\SchoolHealthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolHealth extends EditRecord
{
    protected static string $resource = SchoolHealthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
