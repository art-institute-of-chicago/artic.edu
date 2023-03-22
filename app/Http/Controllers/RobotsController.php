<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends FrontController
{
    public function index(Request $request)
    {
        if (config('app.env') === 'production' && config('app.url') === $request->getHttpHost()) {
            return response()
                ->view('site.robots')
                ->header('Content-Type', 'text/plain');
        }
        return response("User-agent: *\nDisallow: /", 200)
            ->header('Content-Type', 'text/plain');
    }
}
