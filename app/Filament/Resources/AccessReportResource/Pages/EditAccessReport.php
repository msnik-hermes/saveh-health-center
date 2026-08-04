<?php

namespace App\Filament\Resources\AccessReportResource\Pages;

use App\Filament\Resources\AccessReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessReport extends EditRecord
{
    protected static string $resource = AccessReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
