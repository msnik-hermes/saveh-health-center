<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Filament\Auth\Http\Responses\Contracts\LogoutResponse::class,
            \App\Auth\Http\Responses\LogoutResponse::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register RTL CSS for Persian/Farsi support
        Filament::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn () => '<meta name="direction" content="rtl">',
        );

        // RTL CSS is loaded via FilamentAsset in a dedicated service provider.
    }
}
