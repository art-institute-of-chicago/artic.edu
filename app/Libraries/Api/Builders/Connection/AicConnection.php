<?php

namespace App\Libraries\Api\Builders\Connection;
use App\Libraries\Api\Builders\Grammar\AicGrammar;

class AicConnection implements ApiConnectionInterface
{

    protected $client;
    protected $defaultGrammar = 'App\Libraries\Api\Builders\Grammar\AicGrammar';

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

        return $this->client->request($verb, $endpoint, $adaptedParameters);
    }
}
