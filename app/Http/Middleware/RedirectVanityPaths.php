<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\VanityRedirect;

class RedirectVanityPaths
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirect = VanityRedirect::where('path', $request->path())->first();

        if ($redirect) {
            return redirect($redirect->destination);
        }

        return $next($request);
    }
}
