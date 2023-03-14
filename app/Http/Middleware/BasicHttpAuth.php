<?php

namespace App\Http\Middleware;

use Closure;
use Intervention\HttpAuth\Authenticator;

class BasicHttpAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    $logged = false;

    //check if request has authorization header
    if ($request->header('PHP_AUTH_USER', null) && $request->header('PHP_AUTH_PW', null)) {

        $username = $request->header('PHP_AUTH_USER');
        $password = $request->header('PHP_AUTH_PW');

        if ($username === env('HTTPAUTH_USER') && $password === env('HTTPAUTH_PASS')) 
            $logged = true;

    }

    //user not logged, request authentication
    if ($logged === false) {

        $headers = ['WWW-Authenticate' => 'Basic'];
        return response()->make('Invalid credentials.', 401, $headers);

    } else //if succesfull logged, proceed with request
        return $next($request);

}
}
