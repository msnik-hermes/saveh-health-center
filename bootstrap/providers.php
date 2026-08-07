<?php

use App\Filament\AdminPanelProvider;
use App\Providers\AppServiceProvider;
use App\Providers\PersianDateServiceProvider;

return [
    AppServiceProvider::class,
    PersianDateServiceProvider::class,
    AdminPanelProvider::class,
];
