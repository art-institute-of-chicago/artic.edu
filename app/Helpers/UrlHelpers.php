<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('currentUrlWithQuery')) {
    function currentUrlWithQuery($options = [])
    {
        return request()->url() . '?' . http_build_query($options);
    }
}

if (!function_exists('parseYoutubeUrl')) {
    function parseYoutubeUrl($url)
    {
        if (str_contains($url, 'youtu.be')) {
            return ltrim(parse_url($url, PHP_URL_PATH), '/');
        }
        parse_str( parse_url( $url, PHP_URL_QUERY ), $youtube_url);
        return isset($youtube_url['v']) ? $youtube_url['v'] : null;
    }
}


if (!function_exists('secureRoute')) {
    function secureRoute($routeName)
    {
        $url = url();
        $defaultScheme = Request::getScheme();
        $url->forceScheme('https');
        $route = $url->route($routeName);
        $url->forceScheme($defaultScheme);

        return $route;
    }
}
