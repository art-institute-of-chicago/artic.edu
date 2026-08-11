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
        // Preserve the privacy hash for unlisted Vimeo videos:
        // vimeo.com/{id}/{hash}, player.vimeo.com/video/{id}/{hash}, vimeo.com/{id}/{hash}?...
        preg_match('#vimeo\.com/(?:(?!\d+/)[\w-]+/)*(?:video/)?(\d+)(?:/([0-9a-f]+))?#', $url, $matches);

        if (!isset($matches[1])) {
            return 0;
        }

        // Hash may be a path segment or an ?h= query param
        $hash = $matches[2] ?? null;

        if (!$hash && preg_match('/[?&]h=([0-9a-f]+)/', $url, $hashMatches)) {
            $hash = $hashMatches[1];
        }

        return $hash ? $matches[1] . '?h=' . $hash : $matches[1];
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
