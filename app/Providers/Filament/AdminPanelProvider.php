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
use App\Filament\Widgets\CFStatsOverview;
use App\Filament\Widgets\StatusCFChart;
use App\Filament\Widgets\LokasiCFChart;
use App\Filament\Widgets\CFTerbaruTable;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Auth\CustomRegister;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path(app()->isProduction() ? '' : 'admin')
            ->domain(app()->isProduction() ? env('FILAMENT_ADMIN_DOMAIN') : null)
            // ->registration(CustomRegister::class)
            ->brandName(config('app.name_sidebar'))
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                            fn () => view('auth.nifco-logo') // Buat file blade isinya logo NIFCO
                        )
                    )
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                CFStatsOverview::class,
                LokasiCFChart::class,
                StatusCFChart::class,
                CFTerbaruTable::class,
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
