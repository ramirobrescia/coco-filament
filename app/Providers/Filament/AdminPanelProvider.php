<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
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
            ->registration()
            ->colors([
                'amber' => Color::Amber,
                'lime' => Color::Lime,
                'orange' => Color::Orange,
                // 'primary' => Color::Amber,
                'sky' => Color::Sky,
                'yellow' => Color::Yellow,
                // 'primary' => '#2B50A1',
                // 'danger' => '#FF7043',
                // 'success' => '#4CAF50',
                // 'warning' => '#FFD04D',
                // 'gray' => '#FDF4E5',

                'primary' => '#2B50A1',
                'secondary' => '#FFD04D',
                'success' => '#4CAF50',
                'warning' => '#FF7043',
                'background' => '#E9DFC9',
                'surface' => '#FFFFFF',
                'foreground' => '#2B2B2B',
                'border' => '#B8AD9C',

                'dark' => [
                    'primary' => '#90B4F6',
                    'secondary' => '#FFDD7F',
                    'success' => '#81C784',
                    'warning' => '#FFAB91',
                    'background' => '#1F2937',
                    'foreground' => '#F3F4F6',
                    'border' => '#374151',
                ]
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                \TomatoPHP\FilamentCms\FilamentCMSPlugin::make()
                        ->useCategory()
                        ->usePost()
                        // Importante para la selección de idioma de los posts
                        ->defaultLocales(['es', 'en'])
                        ->allowExport()
                        ->allowImport(),
                \Filament\SpatieLaravelTranslatablePlugin::make()->defaultLocales(['es', 'en']),
                \TomatoPHP\FilamentMenus\FilamentMenusPlugin::make(),
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
