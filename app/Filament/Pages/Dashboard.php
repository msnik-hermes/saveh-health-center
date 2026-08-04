<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages;
use Filament\Support\Icons\Heroicon;

class Dashboard extends Pages\Dashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    public function getTitle(): string
    {
        return 'داشبورد مرکز بهداشت';
    }
}
