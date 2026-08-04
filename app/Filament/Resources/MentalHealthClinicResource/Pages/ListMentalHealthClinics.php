<?php

namespace App\Filament\Resources\MentalHealthClinicResource\Pages;

use App\Filament\Resources\MentalHealthClinicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMentalHealthClinics extends ListRecords
{
    protected static string $resource = MentalHealthClinicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
