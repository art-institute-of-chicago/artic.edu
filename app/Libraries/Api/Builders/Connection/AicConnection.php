<?php

namespace App\Libraries\Api\Builders\Connection;

use Illuminate\Support\Arr;
use App\Libraries\Api\Builders\Grammar\AicGrammar;

class AicConnection implements ApiConnectionInterface
{

    protected $client;
    protected $defaultGrammar = 'App\Libraries\Api\Builders\Grammar\AicGrammar';
    protected $cacheKeyName   = 'Aic-cache-key';

    // Define a custom TTL for the queries using this connection instance.
    protected $ttl;

    /**
     * Create a new API connection instance.
     *
     * @param  $endpoint
     * @return void
     */
    public function __construct()
    {
        // Todo: to be changed when we allow to configure things
        $this->client = \App::make('ApiClient');
        $this->useDefaultQueryGrammar();
    }

    protected function useDefaultQueryGrammar()
    {
        $this->queryGrammar = new $this->defaultGrammar;
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
    public function execute($endpoint = null, $params = []) {
        $queryKeys = ['ids', 'include'];
        $queryParams = Arr::only($params, $queryKeys);
        $bodyParams = Arr::except($params, $queryKeys);

        // Some Libraries need to adapt the format for the parameters
        // Guzzle needs to receive ['query' => [ 'par1' => val1, 'par2' => val2 .....]]
        // Let's leave the specific to the clients.
        $adaptedParameters = $this->client->adaptParameters($bodyParams);

        $headers = $this->client->headers($params);
        $options = $headers;
        $verb = 'GET';

        if (!empty($bodyParams)) {
            $adaptedParameters = $this->client->adaptParameters($params);
            $options = array_merge($adaptedParameters, $headers);
            $verb = 'POST';
        }
        else {
            if (!empty($queryParams)) {
                $endpoint = $endpoint .'?' .http_build_query($queryParams);
            }
        }

        // Allow to force the verb used for the calls (GET/POST)
        $verb = config('api.force_verb') ?: $verb;

        if (config('api.logger')) {
            $ttl = $this->ttl ?? config('api.cache_ttl');
            \Log::info($verb . " ttl = ". $ttl . " " . $endpoint);
            \Log::info(print_r($options, true));
        }


        // Perform API request and caching
        if (config('api.cache_enabled')) {
            $cacheKey = $this->buildCacheKey($verb, $endpoint, $options, config('api.cache_version'));

            // Use default TTL if no explicit has been defined
            $ttl = $this->ttl ?? config('api.cache_ttl');

            $response =  \Cache::remember($cacheKey, $ttl, function () use ($verb, $endpoint, $options) {
                // TODO: Somewhere here – figure out if the request failed?
                return $this->client->request($verb, $endpoint, $options);
            });

            if (isset($response->status) && $response->status != 200) {
                \Cache::forget($cacheKey);
            }

            return $response;
        } else {
            return $this->client->request($verb, $endpoint, $options);
        }
    }

    protected function buildCacheKey() {
        return json_encode(func_get_args());
    }
}
