<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\ChangePassword;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PortalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $baseDomain = parse_url(config('app.url'), PHP_URL_HOST) ?: config('app.url');

        $adminDomain = env('ADMIN_PORTAL_DOMAIN', 'admin.' . $baseDomain);

        return $panel
            ->default()
            ->spa(hasPrefetching: true)
            ->id('portal')
            ->path('')
            ->domain($adminDomain)

            ->favicon(
                site_image(
                    siteUrlSettings('site_favicon'),
                    'images/skytech-infranet-logo.png'
                )
            )

            ->brandLogo(
                site_image(
                    siteUrlSettings('site_logo'),
                    'images/skytech-infranet-logo.png'
                )
            )

            ->brandName(
                siteUrlSettings('site_name') ?? 'SKYTECH INFRANET'
            )

            ->brandLogoHeight('3.5rem')

            ->login(Login::class)
            ->registration(null)
            ->authGuard('web')
            ->maxContentWidth(Width::Full)

            ->colors([
                'primary' => Color::hex(
                    siteUrlSettings('theme_primary_color') ?? '#006DB6'
                ),
            ])

            ->sidebarCollapsibleOnDesktop()

            ->pages([
                \App\Filament\Pages\Dashboard::class,
                ChangePassword::class,
            ])

            ->navigationGroups([
                NavigationGroup::make('Customers')
                    ->icon('heroicon-o-users'),

                NavigationGroup::make('Payments')
                    ->icon('heroicon-o-banknotes'),

                NavigationGroup::make('Network')
                    ->icon('heroicon-o-server-stack'),

                NavigationGroup::make('Business')
                    ->icon('heroicon-o-building-storefront'),

                NavigationGroup::make('Reports')
                    ->icon('heroicon-o-chart-bar'),

                NavigationGroup::make('Administration')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])

            ->navigationItems([

                /*
                |--------------------------------------------------------------------------
                | CUSTOMERS
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('All Customers')
                    ->icon('heroicon-o-users')
                    ->group('Customers')
                    ->url(fn () => route('customers.index'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['all-customer']
                    )),

                NavigationItem::make('New Customer')
                    ->icon('heroicon-o-user-plus')
                    ->group('Customers')
                    ->url(fn () => route('new-customer'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['create-customer']
                    )),

                NavigationItem::make('Customer Summary')
                    ->icon('heroicon-o-identification')
                    ->group('Customers')
                    ->url(fn () => route('customer-summary'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['customer-billing-info', 'view-customer']
                    )),

                /*
                |--------------------------------------------------------------------------
                | PAYMENTS
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('Collect Payment')
                    ->icon('heroicon-o-banknotes')
                    ->group('Payments')
                    ->url(fn () => route('payment-collection'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection']
                    )),

                NavigationItem::make('Edit Payment')
                    ->icon('heroicon-o-pencil-square')
                    ->group('Payments')
                    ->url(fn () => route('collection-edit'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection-edit', 'payment-edit']
                    )),

                NavigationItem::make('Invoices')
                    ->icon('heroicon-o-document-text')
                    ->group('Payments')
                    ->url(fn () => route('payment-invoice'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection-invoice']
                    )),

                NavigationItem::make('Payment Reports')
                    ->icon('heroicon-o-chart-bar')
                    ->group('Payments')
                    ->url(fn () => route('customer-summary'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection-report']
                    )),

                /*
                |--------------------------------------------------------------------------
                | NETWORK / MIKROTIK
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('MikroTik Management')
                    ->icon('heroicon-o-server-stack')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-sync'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('IP Setup')
                    ->icon('heroicon-o-globe-alt')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-ip-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('PPPoE')
                    ->icon('heroicon-o-link')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-pppoe-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Queue Management')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-queue-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Firewall')
                    ->icon('heroicon-o-shield-check')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-firewall-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Hotspot')
                    ->icon('heroicon-o-wifi')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-hotspot-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('RADIUS')
                    ->icon('heroicon-o-key')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-radius-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('VPN')
                    ->icon('heroicon-o-lock-closed')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-vpn-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Traffic Monitor')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-traffic-monitor'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Router Logs')
                    ->icon('heroicon-o-document-magnifying-glass')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-log-viewer'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-setup']
                    )),

                NavigationItem::make('Router Backup')
                    ->icon('heroicon-o-archive-box')
                    ->group('Network')
                    ->url(fn () => route('mikrotik-backup-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['mikrotik-auto-backup', 'mikrotik-setup']
                    )),

                /*
                |--------------------------------------------------------------------------
                | BUSINESS
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('Packages')
                    ->icon('heroicon-o-cube')
                    ->group('Business')
                    ->url(fn () => route('package-list-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['package-setup']
                    )),

                NavigationItem::make('SMS')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->group('Business')
                    ->url(fn () => route('sms-setup'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['sms-setup']
                    )),

                NavigationItem::make('Resellers')
                    ->icon('heroicon-o-building-storefront')
                    ->group('Business')
                    ->url(fn () => route('admin.resellers.index'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['create-reseller']
                    )),

                /*
                |--------------------------------------------------------------------------
                | REPORTS
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('Collection Report')
                    ->icon('heroicon-o-chart-pie')
                    ->group('Reports')
                    ->url(fn () => route('collection-report.index'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection-report', 'collection-list']
                    )),

                NavigationItem::make('Customer Reports')
                    ->icon('heroicon-o-chart-bar')
                    ->group('Reports')
                    ->url(fn () => route('customer-summary'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['payment-collection-report']
                    )),

                /*
                |--------------------------------------------------------------------------
                | ADMINISTRATION
                |--------------------------------------------------------------------------
                */

                NavigationItem::make('Users')
                    ->icon('heroicon-o-user-group')
                    ->group('Administration')
                    ->url(fn () => route('admin-users'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['view-user', 'create-user', 'edit-user', 'delete-user']
                    )),

                NavigationItem::make('Roles & Permissions')
                    ->icon('heroicon-o-shield-check')
                    ->group('Administration')
                    ->url(fn () => route('admin-roles'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        [
                            'view-user-role',
                            'create-user-role',
                            'edit-user-role',
                            'delete-user-role',
                        ]
                    )),

                NavigationItem::make('Support Tickets')
                    ->icon('heroicon-o-ticket')
                    ->group('Administration')
                    ->url(fn () => route('admin-tickets'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['manage-tickets', 'view-tickets']
                    )),

                NavigationItem::make('Website Settings')
                    ->icon('heroicon-o-globe-alt')
                    ->group('Administration')
                    ->url(fn () => route('site-settings'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['site-settings', 'site-setup']
                    )),

                NavigationItem::make('Hotel Guests')
                    ->icon('heroicon-o-building-office')
                    ->group('Administration')
                    ->url(fn () => route('hotel.guests'))
                    ->visible(fn () => hasAccess(
                        ['Super Admin'],
                        ['hotel-view-guests']
                    )),
            ])

            ->assets([
                Css::make(
                    'portal-custom-styles',
                    Vite::asset('resources/css/app.css')
                ),

                Js::make(
                    'portal-custom-js',
                    Vite::asset('resources/js/app.js')
                )->module(),
            ])

            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => view(
                    'components.portal-dynamic-theme'
                )->render()
            )

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
