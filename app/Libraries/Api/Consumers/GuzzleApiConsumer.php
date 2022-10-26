<?php

namespace App\Libraries\Api\Consumers;

use GuzzleHttp\Client;

class GuzzleApiConsumer implements ApiConsumerInterface
{
    private $client;

    public function __construct($options = [])
    {
        $this->client = new \GuzzleHttp\Client($options);
    }

    /**
     * Intercept the Guzzle request and return a cleaner object
     *
     */
    public function request($method, $uri = '', array $options = [])
    {
        // WEB-2259, WEB-2345: Allow 4xx and 5xx responses
        $options = array_merge($options, ['http_errors' => false]);

        $response = $this->client->request($method, $uri, $options);
        $contents = $response->getBody()->getContents();
        $body = json_decode($contents);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON: ' . $contents);
        }

        if (is_object($body) && isset($body->error) && $body->status !== 404) {
            throw new \Exception('API error: ' . $contents);
        }

        if (!in_array($response->getStatusCode(), [200, 404])) {
            throw new \Exception('API invalid response: ' . $contents);
        }

        return (object) [
            'body' => $body,
            'status' => $response->getStatusCode()
        ];
    }

    /**
     * Adapt raw parameters to be implemented correctly by the client library.
     * You can send parameters directly, or adapt them manually.
     * This method should be defined for each consumer to ease configuration.
     *
     */
    public function adaptParameters($params)
    {
        return ['body' => json_encode($params)];
    }

    /**
     * Add a default header and merge with headers coming from the parameters
     *
     */
    public function headers($params)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept-Encoding' => 'gzip',
        ];

        if (config('api.token')) {
            $headers = array_merge($headers, [
                'Authorization' => 'Bearer ' . config('api.token'),
            ]);
        }

        if (isset($params['headers'])) {
            $headers = array_merge($default, $params['headers']);
        }

        return ['headers' => $headers];
    }

    /**
     * Captures all method calls, and bypass them to the client in case they don't
     * exists locally. This way it's easier to extend/
     *
     */
    public function __call($name, $args): mixed
    {
        if (isset($this->__classMethods[$name]) && $this->__classMethods[$name] instanceof \Closure) {
            return call_user_func_array($this->__classMethods[$name], $args);
        }

        // If it doesn't exists locally push the call to the API client.
        return $this->client->{$name}(...$args);
    }
}
