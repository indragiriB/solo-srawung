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
use Illuminate\Support\Facades\Blade; // Wajib ditambahkan

class RelawanPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('relawan')
            ->path('relawan')
            ->login()
            
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Slate,
            ])
            ->font('Plus Jakarta Sans')
            ->brandName('SoloSrawung Relawan')
            // 1. Aktifkan Dark Mode (Hapus defaultDarkMode)
            ->darkMode(true)
            
            // 2. Custom CSS Hook (Kunci Tema Gelap & Glassmorphism)
            ->renderHook(
                'panels::head.done',
                fn (): string => Blade::render('
                    <style>
                        /* Memaksa background gelap sejak awal loading */
                        :root { color-scheme: dark; }
                        body { background-color: #0f172a !important; }
                        
                        .fi-main-ctn { background-color: #0f172a !important; }
                        .fi-sidebar { 
                            background-color: #020617 !important; 
                            border-right: 1px solid rgba(255,255,255,0.05) !important; 
                        }
                        
                        /* Card Bergaya Glassmorphism */
                        .fi-wi-stats-overview-stat-card, .fi-section, .fi-ta-ctn {
                            background: rgba(30, 41, 59, 0.4) !important;
                            backdrop-filter: blur(8px) !important;
                            border: 1px solid rgba(255, 255, 255, 0.05) !important;
                            border-radius: 1.25rem !important;
                        }

                        /* Judul Brand dengan Gradasi Amber-Orange */
                        .fi-sidebar-header .fi-logo, .fi-brand {
                            background: linear-gradient(to right, #f59e0b, #d97706) !important;
                            -webkit-background-clip: text !important;
                            -webkit-text-fill-color: transparent !important;
                            font-weight: 800 !important;
                        }
                    </style>
                '),
            )
            ->discoverResources(in: app_path('Filament/Relawan/Resources'), for: 'App\\Filament\\Relawan\\Resources')
            ->discoverPages(in: app_path('Filament/Relawan/Pages'), for: 'App\\Filament\\Relawan\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Relawan/Widgets'), for: 'App\\Filament\\Relawan\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Filament\Http\Middleware\DisableBladeIconComponents::class,
                \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);


            
    }

    
}