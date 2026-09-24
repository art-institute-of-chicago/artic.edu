<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Sentry\Laravel\Integration;
use Aic\Hub\Foundation\Exceptions\AbstractException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
    ->withMiddleware(function (Middleware $middleware): void {
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
            \App\Http\Middleware\SanitizeQueryParameters::class,
            \App\Http\Middleware\CheckFileExtension::class,
        ]);

        // Not applied to any group automatically — routes opt in via
        // ->withoutMiddleware('sessionless') to skip session/server-side CSRF handling
        // (and the Set-Cookie headers that come with it) so their responses
        // can be edge-cached. Only safe for routes/views that never read or
        // write session state.
        $middleware->group('sessionless', [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Always render JSON for API routes, regardless of the request's Accept header
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Render our own exceptions (and any other exception once debugging is off) using
        // our API's standard {status, error, detail} shape instead of Laravel's default
        // error page/stack trace dump
        $exceptions->render(function (Throwable $e, $request) {
            // If these aren't API requests, exit
            if (!$request->is('api/*') && !$request->expectsJson()) {
                return null;
            }

            $isDetailed = $e instanceof AbstractException;

            // Laravel's debug page is too useful to forgo for genuinely unexpected errors
            // If we're in debug mode and the error isn't our own, exit
            if (config('app.debug') && !$isDetailed) {
                return null;
            }

            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

            $response = [
                'status' => $status,
                'error' => 'Sorry, something went wrong.',
                'detail' => 'An unrecognized exception was thrown. Our developers have been alerted to the situation.',
            ];

            if ($isDetailed) {
                $response['error'] = $e->getMessage();
                $response['detail'] = $e->getDetail();
            }

            return response()->json($response, $status);
        });

        // Sentrty error reporting
        $exceptions->reportable(function (Throwable $e) {
            Integration::captureUnhandledException($e);
        });
    })->create();
