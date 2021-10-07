<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Routing\Controller as BaseController;

class PreviewController extends BaseController
{
    public function show($hash)
    {
        // Structured like //host.example/path?query=foobar
        $route = decrypt($hash);

        // Check this config when determining published status
        config(['aic.is_preview_mode' => true]);

        // We just want to extract the /path, starting with /
        $path = parse_url($route, PHP_URL_PATH);

        // Get ServerBag of current reqest, rewrite URI, convert to array
        $server = request()->server;
        $server->set('REQUEST_URI', $path);
        $server = $server->all();

        // Rewrite the current request with one containing the new path
        $request = request()->duplicate(null, null, null, null, null, $server);
        app()->request = $request;

        // Now, calling request() returns the new request!
        return Route::dispatch($request)->getContent();
    }
}
