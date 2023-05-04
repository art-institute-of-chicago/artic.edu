<?php

namespace App\Libraries\Api\Builders\Connection;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Arr;

class AicConnection implements ApiConnectionInterface
{
    protected $client;
    protected $defaultGrammar = 'App\Libraries\Api\Builders\Grammar\AicGrammar';
    protected $cacheKeyName = 'Aic-cache-key';

    /**
     * Define a custom TTL for the queries using this connection instance.
     */
    protected $ttl;

    /**
     * Create a new API connection instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = \App::make('ApiClient');
        $this->useDefaultQueryGrammar();
    }

    protected function useDefaultQueryGrammar()
    {
        $this->queryGrammar = new $this->defaultGrammar();
    }

    public function getQueryGrammar()
    {
        return $this->queryGrammar;
    }

    public function setQueryGrammar($queryGrammar)
    {
        return $this->queryGrammar = $queryGrammar;
    }

    /**
     * Define a custom TTL for this connection instance
     *
     * @param  integer  $ttl
     * @return object
     */
    public function ttl($ttl = null)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Run a get statement against the API.
     *
     * @param  array  $params
     * @return object
     */
    public function get($endpoint, $params)
    {
        $response = $this->execute($endpoint, $params);

        return $response;
    }

    /**
     * Execute a general call to the API client
     *
     * @param  array  $params
     * @return object
     */
    public function execute($endpoint = null, $params = [])
    {
        $headers = $this->client->headers($params);
        $options = $headers;

        $queryKeys = ['ids', 'include'];
        $queryParams = Arr::only($params, $queryKeys);
        $bodyParams = Arr::except($params, $queryKeys);

        $verb = empty($bodyParams) ? 'GET' : 'POST';

        if (in_array(config('api.force_verb'), ['GET', 'POST'])) {
            $verb = config('api.force_verb');
        }

        if ($verb === 'GET') {
            if (!empty($params)) {
                // WEB-979: See DecodeParams middleware in data-aggregator
                $endpoint = $endpoint . '?params=' . urlencode(json_encode($params));
            }
        } else {
            if (!empty($bodyParams)) {
                $adaptedParameters = $this->client->adaptParameters($params);
                $options = array_merge($adaptedParameters, $headers);
            }
        }

        if (config('api.logger')) {
            $ttl = $this->ttl ?? config('api.cache_ttl');
            \Log::info($verb . ' ttl = ' . $ttl . ' ' . $endpoint);
            \Log::info(print_r($options, true));
        }

        // Perform API request and caching
        if (config('api.cache_enabled')) {
            $cacheKey = $this->buildCacheKey($verb, $endpoint, $options, config('api.cache_version'));

            // Manual cachebusting
            $decacheHash = Request::input('nocache');

            if ($decacheHash && config('api.cache_buster') && $decacheHash === config('api.cache_buster')) {
                \Cache::forget($cacheKey);
            }

            // Use default TTL if no explicit has been defined
            $ttl = $this->ttl ?? config('api.cache_ttl');

            $response = \Cache::remember($cacheKey, $ttl, function () use ($verb, $endpoint, $options) {
                // WEB-2259: Error handling is done in the ApiConsumer
                return $this->client->request($verb, $endpoint, $options);
            });

            if (isset($response->status) && $response->status != 200) {
                \Cache::forget($cacheKey);
            }

            return $response;
        }

        return $this->client->request($verb, $endpoint, $options);
    }

    /**
     * WEB-1805: The cache key *must* be 250 bytes or less! Otherwise, it'll silently fail on the lookup.
     */
    protected function buildCacheKey()
    {
        return md5(json_encode(func_get_args()));
    }
}
