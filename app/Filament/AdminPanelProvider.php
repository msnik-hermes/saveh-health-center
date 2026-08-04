<?php

namespace App\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
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
            ->brandName('مرکز بهداشت ساوه')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::hex('#2d6b4b'),
                'success' => Color::hex('#3f8760'),
                'warning' => Color::hex('#c47b2d'),
                'danger' => Color::Rose,
                'info' => Color::hex('#3d6b78'),
                'gray' => Color::Stone,
            ])
            ->font('Vazirmatn')
            ->viteTheme('resources/css/filament/admin-theme.css')
            ->darkMode(true)
            ->maxContentWidth(Width::Full)
            // Always keep sidebar expanded so labels stay visible
            ->sidebarCollapsibleOnDesktop(false)
            ->sidebarFullyCollapsibleOnDesktop(false)
            ->collapsibleNavigationGroups(false)
            ->sidebarWidth('19rem')
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => Blade::render('@include("filament.hooks.force-sidebar-open")'),
            )
            // IMPORTANT (Filament rule): group icons OR item icons, not both.
            // We keep icons on each menu item and leave groups label-only.
            ->navigationGroups([
                NavigationGroup::make('سازمان')->collapsed(false)->collapsible(false),
                NavigationGroup::make('منابع انسانی')->collapsed(false)->collapsible(false),
                NavigationGroup::make('پشتیبانی و ناوگان')->collapsed(false)->collapsible(false),
                NavigationGroup::make('سلامت خانواده')->collapsed(false)->collapsible(false),
                NavigationGroup::make('سلامت و درمان')->collapsed(false)->collapsible(false),
                NavigationGroup::make('بازرسی و ایمنی')->collapsed(false)->collapsible(false),
                NavigationGroup::make('مالی و انبار')->collapsed(false)->collapsible(false),
                NavigationGroup::make('آموزش')->collapsed(false)->collapsible(false),
                NavigationGroup::make('فرم‌ها')->collapsed(false)->collapsible(false),
                NavigationGroup::make('گردش‌کار')->collapsed(false)->collapsible(false),
                NavigationGroup::make('امنیت و دسترسی')->collapsed(false)->collapsible(false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                \App\Filament\Widgets\OrganizationStatsWidget::class,
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
            ]);
    }
}
