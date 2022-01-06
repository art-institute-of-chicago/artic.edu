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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirect = VanityRedirect::published()->where('path', strtolower($request->path()))->first();

        if ($redirect) {
            return redirect($redirect->destination);
        }

        return $next($request);
    }
}
