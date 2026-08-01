<?php

namespace App\Filament\Pages;

use Filament\Pages;

class Dashboard extends Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getTitle(): string
    {
        return 'داشبورد مرکز بهداشت';
    }
}
