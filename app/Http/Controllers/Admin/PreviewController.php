<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Routing\Controller as BaseController;

class PreviewController extends BaseController
{

    public function show($hash)
    {
        $route = decrypt($hash);
        config(['aic.is_current_request_preview' => true]);
        $request = Request::create($route);
        return Route::dispatch($request)->getContent();
    }

}
