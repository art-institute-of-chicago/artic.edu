<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class RedirectController extends BaseController
{
    public function today()
    {
        $today = Carbon::today()->format('m/d/Y');

        return redirect()
            ->away(config('aic.sales_site_url') . '/Tickets/Info?id=2&date=' . $today)
            ->header('Cache-Control', 'public')
            ->header('Expires', Carbon::tomorrow()->toRfc7231String());
    }
}
