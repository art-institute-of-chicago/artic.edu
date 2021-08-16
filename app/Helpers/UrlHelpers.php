<?php

use Illuminate\Support\Str;
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

if (!function_exists('moduleRouteExists')) {
    /**
     * Whether a module route exists
     * @see moduleRoute
     */
    function moduleRouteExists($moduleName, $prefix, $action)
    {
        $routeName = 'admin.' . ($prefix ? $prefix . '.' : '') . Str::camel($moduleName) . '.' . $action;
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
