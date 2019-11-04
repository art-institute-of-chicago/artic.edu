<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

class GeotargetController extends BaseController
{
    public function geotarget(Request $request)
    {
        return [
            'is_local' => $this->getIsLocal(request()->ip()),
        ];
    }

    private function getIsLocal($ip)
    {
        // Will be "" for https://ipinfo.io/bogon
        // Response is a string that ends with a newline
        $url = 'https://ipinfo.io/' . $ip . '/loc?token=' . config('app.ipinfo');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disable SSL cert verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            return null;
        }

        list($lat, $long) = array_map('floatval', explode(',', $response, 2));

        $distMeters = $this->haversineGreatCircleDistance($lat, $long, 41.8500, -87.6500);
        $distMiles = $distMeters / 1609.344;

        return $distMiles < 200;
    }

    /**
    * Calculates the great-circle distance between two points, with
    * the Haversine formula.
    * @link https://stackoverflow.com/questions/14750275/haversine-formula-with-php
    * @param float $latitudeFrom Latitude of start point in [deg decimal]
    * @param float $longitudeFrom Longitude of start point in [deg decimal]
    * @param float $latitudeTo Latitude of target point in [deg decimal]
    * @param float $longitudeTo Longitude of target point in [deg decimal]
    * @param float $earthRadius Mean earth radius in [m]
    * @return float Distance between points in [m] (same as earthRadius)
    */
    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
