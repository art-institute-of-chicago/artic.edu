<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class KioskMode
{
    /**
     * Only the worthy domains shall bear the mark of kiosk mode!
     */
    public function handle(Request $request, Closure $next): Response
    {
        $kioskDomains = config('app.kiosk_domain');
        $kioskDomains = is_array($kioskDomains) ? $kioskDomains : [$kioskDomains];

        $currentHost = $request->getHost(); // Changed from getHttpHost()

        if (in_array($currentHost, $kioskDomains)) {
            View::share('isKiosk', true);
        }

        return $next($request);
    }
}
