<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class GeotargetController extends BaseController
{
    public function geotarget(Request $request)
    {
        // Will be "" for https://ipinfo.io/bogon
        // Response is a string that ends with a newline
        $url = 'https://ipinfo.io/' . request()->ip() . '/city?token=' . config('app.ipinfo');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disable SSL cert verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        return [
            'is_local' => (empty($response) ? null : (strpos($response, 'Chicago') !== false)),
        ];
    }
}
