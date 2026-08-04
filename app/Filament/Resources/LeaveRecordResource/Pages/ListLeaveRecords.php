<?php

namespace App\Filament\Resources\LeaveRecordResource\Pages;

use App\Filament\Resources\LeaveRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaveRecords extends ListRecords
{
    protected static string $resource = LeaveRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
