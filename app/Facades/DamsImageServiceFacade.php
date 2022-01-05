<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class DamsImageServiceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'damsimageservice';
    }

    public static function getUrl($id, array $params = [])
    {
        $service = \App::make('damsimageservice');

        return $service->getUrl($id, $params);
    }

    public static function getBaseUrl()
    {
        $service = \App::make('damsimageservice');

        return $service->getBaseUrl();
    }

    public static function getVersion()
    {
        $service = \App::make('damsimageservice');

        return $service->getVersion();
    }
}
