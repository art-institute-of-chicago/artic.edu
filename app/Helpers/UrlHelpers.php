<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class UrlHelpers
{
    public static function currentUrlWithQuery($options = [])
    {
        return request()->url() . '?' . http_build_query($options);
    }

    public static function parseVideoUrl($url)
    {
        preg_match('/\d+/', $url, $matches);

        return $matches[0] ?? 0;
    }

    public static function secureRoute($routeName)
    {
        $url = url();
        $defaultScheme = Request::getScheme();
        if (app()->environment(['production', 'staging'])) {
            $url->forceScheme('https');
        }
        $route = $url->route($routeName);
        if (app()->environment(['production', 'staging'])) {
            $url->forceScheme($defaultScheme);
        }

        return $route;
    }

    /**
     * Whether a module route exists
     *
     * @see moduleRoute
     */
    public static function moduleRouteExists($moduleName, $prefix, $action)
    {
        $routeName = 'admin.' . ($prefix ? $prefix . '.' : '') . Str::camel($moduleName) . '.' . $action;

        return Route::has($routeName);
    }

    public static function lastUrlSegment($href)
    {
        $url = parse_url($href, PHP_URL_PATH);
        $ret = substr($url, strrpos($url, '/') + 1);

        $fragment = parse_url($href, PHP_URL_FRAGMENT);

        if ($fragment) {
            return $ret . '#' . $fragment;
        }

        return $ret;
    }
}
