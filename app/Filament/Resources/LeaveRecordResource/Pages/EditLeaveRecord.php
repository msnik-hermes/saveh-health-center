<?php

namespace App\Filament\Resources\LeaveRecordResource\Pages;

use App\Filament\Resources\LeaveRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveRecord extends EditRecord
{
    protected static string $resource = LeaveRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
