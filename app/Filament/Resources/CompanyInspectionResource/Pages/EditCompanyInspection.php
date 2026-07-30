<?php

namespace App\Filament\Resources\CompanyInspectionResource\Pages;

use App\Filament\Resources\CompanyInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyInspection extends EditRecord
{
    protected static string $resource = CompanyInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
