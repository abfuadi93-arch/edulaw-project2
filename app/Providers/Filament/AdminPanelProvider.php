<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\InsightResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->passwordReset()
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): string => view('filament.theme.console')->render()
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): string => view('filament.theme.topbar-actions')->render()
            )
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => view('filament.theme.topbar-user-label')->render()
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn (): string => Blade::render(<<<'BLADE'
                    @if (config('services.google.enabled') && config('services.google.client_id') && config('services.google.client_secret'))
                        <div class="mt-4">
                            <div class="relative mb-3">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="bg-white px-3 text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                                        atau
                                    </span>
                                </div>
                            </div>

                            <a
                                href="{{ route('auth.google.redirect') }}"
                                class="flex w-full items-center justify-center gap-3 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800"
                            >
                                <span class="text-base font-bold">G</span>
                                <span>Masuk dengan Google</span>
                            </a>
                        </div>
                    @endif
                BLADE)
            )
            ->emailVerification()
            ->registration(Register::class)
            ->profile(EditProfile::class, isSimple: false)
            ->brandName('Edulaw Console')
            ->brandLogo(fn (): HtmlString => new HtmlString(view('filament.theme.brand-logo')->render()))
            ->brandLogoHeight('2.5rem')
            ->font('Inter', url: 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap')
            ->globalSearch()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldKeyBindingSuffix()
            ->colors([
                'primary' => [
                    50 => '#eff6ff',
                    100 => '#dbeafe',
                    200 => '#bfdbfe',
                    300 => '#93c5fd',
                    400 => '#60a5fa',
                    500 => '#2563eb',
                    600 => '#1d4ed8',
                    700 => '#1e40af',
                    800 => '#1e3a8a',
                    900 => '#10265f',
                    950 => '#061638',
                ],
                'gray' => [
                    50 => '#f8fafc',
                    100 => '#f1f5f9',
                    200 => '#e2e8f0',
                    300 => '#cbd5e1',
                    400 => '#94a3b8',
                    500 => '#64748b',
                    600 => '#475569',
                    700 => '#334155',
                    800 => '#1e293b',
                    900 => '#0f172a',
                    950 => '#020617',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                Dashboard::class,
            ])
            ->navigationGroups([
                'Overview',
                'Edulaw Insight',
                'Akun',
                'Konten Website',
                'Pengaturan Website',
            ])
            ->navigationItems([
                NavigationItem::make('Tulis Insight')
                    ->group('Edulaw Insight')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn (): string => InsightResource::getUrl('create'))
                    ->sort(2)
                    ->visible(fn (): bool => auth()->user()?->isContributor())
                    ->isActiveWhen(fn (): bool => request()->is('admin/insights/create')),

                NavigationItem::make('Draft')
                    ->group('Edulaw Insight')
                    ->icon('heroicon-o-document')
                    ->url(fn (): string => InsightResource::getUrl('index', [
                        'tableFilters' => [
                            'status' => [
                                'value' => 'draft',
                            ],
                        ],
                    ]))
                    ->sort(3)
                    ->visible(fn (): bool => auth()->user()?->isContributor())
                    ->isActiveWhen(fn (): bool => request()->is('admin/insights') && request()->input('tableFilters.status.value') === 'draft'),

                NavigationItem::make('Terbit')
                    ->group('Edulaw Insight')
                    ->icon('heroicon-o-check-circle')
                    ->url(fn (): string => InsightResource::getUrl('index', [
                        'tableFilters' => [
                            'status' => [
                                'value' => 'published',
                            ],
                        ],
                    ]))
                    ->sort(6)
                    ->visible(fn (): bool => auth()->user()?->isContributor())
                    ->isActiveWhen(fn (): bool => request()->is('admin/insights') && request()->input('tableFilters.status.value') === 'published'),

                NavigationItem::make('Dalam Review')
                    ->group('Edulaw Insight')
                    ->icon('heroicon-o-clock')
                    ->url(fn (): string => InsightResource::getUrl('index', [
                        'tableFilters' => [
                            'status' => [
                                'value' => 'submitted',
                            ],
                        ],
                    ]))
                    ->sort(4)
                    ->visible(fn (): bool => auth()->user()?->isContributor())
                    ->isActiveWhen(fn (): bool => request()->is('admin/insights') && in_array(request()->input('tableFilters.status.value'), ['submitted', 'under_review'], true)),

                NavigationItem::make('Profil Penulis')
                    ->group('Akun')
                    ->icon('heroicon-o-identification')
                    ->url(fn (): string => url('/admin/profile'))
                    ->sort(1)
                    ->visible(fn (): bool => auth()->user()?->isContributor())
                    ->isActiveWhen(fn (): bool => request()->is('admin/profile')),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
