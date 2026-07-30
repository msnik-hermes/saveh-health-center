<?php

namespace App\Filament\Resources\CompanyInspectionResource\Pages;

use App\Filament\Resources\CompanyInspectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyInspections extends ListRecords
{
    protected static string $resource = CompanyInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
