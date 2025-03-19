<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
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
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Override middleware so we can add our own TrustProxies middleware
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            \Illuminate\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->trustHosts();

        $middleware->web(append: [
            \App\Http\Middleware\RedirectVanityPaths::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Sentrty error reporting
        Integration::handles($exceptions);
    })->create();
