<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->brandLogo(asset('images/banner.png'))
            ->darkModeBrandLogo(asset('images/banner.png'))
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => [
                    50 => '250, 245, 235',
                    100 => '245, 235, 220',
                    200 => '230, 210, 180',
                    300 => '205, 175, 140',
                    400 => '180, 140, 100',
                    500 => '155, 110, 70',
                    600 => '130, 90, 55',
                    700 => '105, 70, 45',
                    800 => '80, 55, 35',
                    900 => '60, 40, 25',
                    950 => '40, 25, 15',
                ],
                'danger' => Color::Rose,
                'gray' => [
                    50 => '250, 248, 246',
                    100 => '245, 242, 238',
                    200 => '235, 230, 224',
                    300 => '215, 208, 200',
                    400 => '175, 165, 155',
                    500 => '135, 125, 115',
                    600 => '105, 95, 85',
                    700 => '85, 75, 68',
                    800 => '65, 58, 52',
                    900 => '45, 40, 36',
                    950 => '30, 26, 23',
                ],
                'info' => Color::Sky,
                'success' => [
                    50 => '245, 250, 245',
                    100 => '235, 245, 235',
                    200 => '200, 230, 200',
                    300 => '160, 205, 160',
                    400 => '120, 175, 120',
                    500 => '90, 145, 90',
                    600 => '70, 120, 70',
                    700 => '55, 95, 55',
                    800 => '45, 75, 45',
                    900 => '35, 55, 35',
                    950 => '25, 35, 25',
                ],
                'warning' => [
                    50 => '255, 250, 240',
                    100 => '255, 245, 225',
                    200 => '255, 230, 190',
                    300 => '250, 210, 150',
                    400 => '240, 185, 110',
                    500 => '225, 160, 75',
                    600 => '200, 135, 55',
                    700 => '170, 110, 45',
                    800 => '140, 90, 35',
                    900 => '110, 70, 30',
                    950 => '80, 50, 20',
                ],
            ])
            ->darkMode(true)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])
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
            ->authGuard('web');
            // ->databaseNotifications()
            // ->databaseNotificationsPolling('30s');
    }
}
