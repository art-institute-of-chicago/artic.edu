<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->routes(function () {
            // API routes
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // Kiosk routes
            // These routes are typically stateless
            $domains = config('app.kiosk_domain');
            $domains = is_array($domains) ? $domains : [$domains];

            foreach ($domains as $domain) {
                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/kiosk.php'));
            }

            // Web routes
            // These routes all receive session state, CSRF protection, etc.
            $allowedDomains = config('app.allowed_domains') ?? [config('app.url')];
            $host = request()->getHttpHost();
            $domain = in_array($host, $allowedDomains) ? $host : config('app.url');
            if (filter_var($host, FILTER_VALIDATE_IP) !== false) {
                $interfaces = net_get_interfaces();
                $ip = FrontendHelpers::ip($interfaces);
                if ($host == $ip) {
                    $domain = $host;
                }
            }

            Route::middleware('web')
                ->domain($domain)
                ->group(base_path('routes/web.php'));
        });
        parent::boot();
    }
}
