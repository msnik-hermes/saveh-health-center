<?php

namespace App\Filament\Resources\SecurityPolicyResource\Pages;

use App\Filament\Resources\SecurityPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecurityPolicies extends ListRecords
{
    protected static string $resource = SecurityPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
