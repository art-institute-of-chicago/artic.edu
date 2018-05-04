<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class LakeviewImageServiceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lakeviewimageservice';
    }

    public static function getUrl($id, array $params = [])
    {
        $service = \App::make('lakeviewimageservice');
        return $service->getUrl($id, $params);
    }

    public static function getBaseUrl()
    {
        $service = \App::make('lakeviewimageservice');
        return $service->getBaseUrl();
    }

    public static function getVersion()
    {
        $service = \App::make('lakeviewimageservice');
        return $service->getVersion();
    }
}
