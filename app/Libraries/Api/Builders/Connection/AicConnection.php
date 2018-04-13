<?php

namespace App\Libraries\Api\Builders\Connection;
use App\Libraries\Api\Builders\Grammar\AicGrammar;

class AicConnection implements ApiConnectionInterface
{

    protected $client;
    protected $defaultGrammar = 'App\Libraries\Api\Builders\Grammar\AicGrammar';
    protected $cacheKeyName   = 'Aic-cache-key';

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
     * Run a get statement against the API.
     *
     * @param  array  $params
     * @return object
     */
    public function get($endpoint, $params)
    {
        $response = $this->execute('GET', $endpoint, $params);

        return $response;
    }

    /**
     * Execute a general call to the API client
     *
     * @param  array  $params
     * @return object
     */
    public function execute($verb = 'GET', $endpoint = null, $params = []) {
        // Some Libraries need to adapt the format for the parameters
        // Guzzle needs to receive ['query' => [ 'par1' => val1, 'par2' => val2 .....]]
        // Let's leave the specific to the clients.
        $adaptedParameters = $this->client->adaptParameters($params);
        $headers = $this->client->headers($params);

        $options = array_merge($adaptedParameters, $headers);

        // Perform API request and caching
        if (config('api.cache_enabled')) {
            $cacheKey = $this->buildCacheKey($verb, $endpoint, $options, config('api.cache_version'));

            return \Cache::remember($cacheKey, config('api.cache_ttl'), function () use ($verb, $endpoint, $options) {
                return $this->client->request($verb, $endpoint, $options);
            });
        } else {
            return $this->client->request($verb, $endpoint, $options);
        }
    }

    protected function buildCacheKey() {
        return json_encode(func_get_args());
    }
}
