<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

class CookieController extends BaseController
{
    public function notification($minutes = 1440)
    {
        return response()
            ->json(['has_seen_notification' => 'true'])
            ->cookie('has_seen_notification', 'true', $minutes);
    }
}
