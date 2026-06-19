<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;

class QcPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('qc')
            ->path(app()->isProduction() ? '' : 'qc')
            ->domain(app()->isProduction() ? env('FILAMENT_QC_DOMAIN') : null)
            ->login()
            ->brandName(config('app.name_sidebar'))
            ->viteTheme('resources/css/filament/qc/theme.css')
            ->colors([
                'primary' => Color::hex('#ff7900'),
            ])
            ->plugin(
                AuthDesignerPlugin::make()
                    ->login(fn ($config) => $config
                        ->media(asset('nifco-id.png'))
                        ->mediaPosition(MediaPosition::Cover)
                        ->blur(4)
                        ->renderHook(
                            \Caresome\FilamentAuthDesigner\View\AuthDesignerRenderHook::CardBefore,
                            fn () => view('auth.nifco-logo')
                        )
                    )
            )   
            ->discoverResources(in: app_path('Filament/Qc/Resources'), for: 'App\Filament\Qc\Resources')
            ->discoverPages(in: app_path('Filament/Qc/Pages'), for: 'App\Filament\Qc\Pages')
            ->discoverWidgets(in: app_path('Filament/Qc/Widgets'), for: 'App\Filament\Qc\Widgets')
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
            ]);
    }
}
