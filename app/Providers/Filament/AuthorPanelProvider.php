<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Author\Resources;
use App\Filament\Widgets\StatsWidget;
use App\Filament\Author\Widget\LatestBlogsWidget;
use App\Filament\Author\Widgets\LatestCommentsWidget;

class AuthorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('author')
            ->path('author')
            ->login()
            ->registration()
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName('Blog Filament - Author')
            ->discoverResources(in: app_path('Filament/Author/Resources'), for: 'App\\Filament\\Author\\Resources')
            ->discoverPages(in: app_path('Filament/Author/Pages'), for: 'App\\Filament\\Author\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Author/Widgets'), for: 'App\\Filament\\Author\\Widgets')
            ->widgets([
                StatsWidget::class,
                LatestCommentsWidget::class,
            ])
            ->authGuard('authors')
            ->authPasswordBroker('authors')
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
                // \App\Http\Middleware\CheckAuthorApproval::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
            
    }
}
