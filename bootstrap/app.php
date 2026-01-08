<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
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

            Route::middleware('web')
                ->domain($domain)
                ->group(base_path('routes/web.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Override middleware so we can add our own TrustProxies middleware
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            \Illuminate\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \App\Http\Middleware\KioskMode::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->trustHosts(function () {
            return config('aic.trust_hosts');
        });

        $middleware->appendToGroup('admin', $middleware->getMiddlewareGroups()['web']);

        $middleware->web(append: [
            \App\Http\Middleware\RedirectVanityPaths::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Sentrty error reporting
        Integration::handles($exceptions);
    })->create();
