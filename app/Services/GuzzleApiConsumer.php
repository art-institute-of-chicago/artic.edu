<?php

namespace App\Services;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GuzzleApiConsumer
{

    private $client;

    function __construct($options = []) {
        $this->client = new \GuzzleHttp\Client($options);
    }




    /**
     * Add your functions here to extend the API consumer
     *
     */





    public function request($method, $uri = '', array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);

        //TODO: Add error controls

        $body = json_decode($response->getBody()->getContents());

        return (object) ['data' => $body->data, 'status' => 200];
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
