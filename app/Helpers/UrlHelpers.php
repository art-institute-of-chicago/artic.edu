<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

if (!function_exists('currentUrlWithQuery')) {
    function currentUrlWithQuery($options = [])
    {
        return request()->url() . '?' . http_build_query($options);
    }
}

if (!function_exists('parseVideoUrl')) {
    function parseVideoUrl($url)
    {
        preg_match('/\d+/', $url, $matches);
        return isset($matches[0]) ? $matches[0] : 0;
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

// derived from moduleRoute
if (!function_exists('moduleRouteExists')) {
    function moduleRouteExists($moduleName, $prefix, $action)
    {
        $routeName = 'admin.' . ($prefix ? $prefix . '.' : '') . camel_case($moduleName) . '.' . $action;
        return Route::has($routeName);
    }
}


if (!function_exists('lastUrlSegment')) {
    function lastUrlSegment($href)
    {
        $url = parse_url($href, PHP_URL_PATH);
        $ret = substr($url, strrpos($url, '/')+1);

        $fragment = parse_url($href, PHP_URL_FRAGMENT);
        if ($fragment) {
            return $ret . '#' . $fragment;
        }
        return $ret;
    }
}

