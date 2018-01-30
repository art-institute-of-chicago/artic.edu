<?php

namespace App\Libraries\Api\Consumers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GuzzleApiConsumer implements ApiConsumerInterface
{

    private $client;

    function __construct($options = []) {
        $this->client = new \GuzzleHttp\Client($options);
    }

    /**
     * Intercept the Guzzle request and return a cleaner object
     *
     */
    public function request($method, $uri = '', array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);
        $body = json_decode($response->getBody()->getContents());

        return (object) [
            'body'       => $body,
            'status'     => $response->getStatusCode()
        ];
    }

    /**
     * Adapt raw parameters to be implemented correctly by the client library.
     * You can send parameters directly, or adapt them manually.
     * This method should be defined for each consumer to ease configuration.
     *
     */
    public function adaptParameters($params) {
        return ['query' => $params];
    }

    /**
     * Captures all method calls, and bypass them to the client in case they don't
     * exists locally. This way it's easier to extend/
     *
     */
    public function __call($name, $args)
    {
        if (isset($this->__classMethods[$name]) && $this->__classMethods[$name] instanceof \Closure) {
            return call_user_func_array($this->__classMethods[$name], $args);
        }

        if (get_parent_class()) {
            return parent::__call($name, $args);
        }

        // If it doesn't exists locally push the call to the API client.
        return $this->client->$name(...$args);
    }

}
