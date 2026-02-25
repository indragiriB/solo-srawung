<?php

namespace App\Providers\Filament;

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
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            ->colors([
                'primary' => Color::Indigo,
                'warning' => Color::Amber,
                'gray' => Color::Slate,
            ])
            ->font('Plus Jakarta Sans')
            ->brandName('SoloSrawung')
            ->darkMode(true)
            // Render Hook yang aman dari error sintaks
            ->renderHook(
                'panels::head.done',
                fn (): string => Blade::render('
                    <style>
                        body { background-color: #0f172a !important; }
                        .fi-main-ctn { background-color: #0f172a !important; }
                        .fi-sidebar { background-color: #020617 !important; }
                        .fi-wi-stats-overview-stat-card, .fi-section, .fi-ta-ctn {
                            background: rgba(30, 41, 59, 0.4) !important;
                            backdrop-filter: blur(8px) !important;
                            border: 1px solid rgba(255, 255, 255, 0.05) !important;
                        }
                    </style>
                '),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // Matikan dulu discovery widget yang folder-nya aneh untuk mencegah loop
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Daftarkan manual sesuai path folder asli kamu sekarang
                \App\Filament\Resources\AdminResource\Widgets\StatsOverview::class,
                \App\Filament\Resources\AdminResource\Widgets\AttendanceChart::class,
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