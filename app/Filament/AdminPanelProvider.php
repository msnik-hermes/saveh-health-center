<?php

namespace App\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('سیستم مدیریت مرکز بهداشت ساوه')
            ->brandLogo(asset('images/logo.svg'))
            ->favicon(asset('images/favicon.ico'))
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Info,
                'success' => Color::Success,
                'warning' => Color::Warning,
            ])
            ->directory('resources/views/vendor/filament')
            ->resources([
                \App\Filament\Resources\CompanyResource::class,
                \App\Filament\Resources\CenterResource::class,
                \App\Filament\Resources\EmployeeResource::class,
                \App\Filament\Resources\FacilityRequestResource::class,
                \App\Filament\Resources\ItRequestResource::class,
                \App\Filament\Resources\VehicleRequestResource::class,
                \App\Filament\Resources\InspectionResource::class,
                \App\Filament\Resources\CompanyInspectionResource::class,
                \App\Filament\Resources\PregnantWomanResource::class,
                \App\Filament\Resources\DiseaseSurveillanceResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->theme('filament.theme')
            ->viteTheme('resources/css/app.css');
    }
}
