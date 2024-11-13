<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Filament\Widgets\AdminNotificationsWidget;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;
use Illuminate\Support\AdminPanelProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::serving(function () {
        //     Filament::databaseNotifications();
        // });
        // Filament::serving(function () {
        //     Filament::registerRenderHook('filament.auth.onLogin', function () {
        //         return redirect()->route('your.custom.route'); // Specify your custom route here
        //     });
        // });
    }
}
