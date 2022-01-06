<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class EmbedConverterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'embedconverterservice';
    }

    public static function convertUrl($url)
    {
        $service = \App::make('embedconverterservice');

        return $service->convertUrl($url);
    }
}
