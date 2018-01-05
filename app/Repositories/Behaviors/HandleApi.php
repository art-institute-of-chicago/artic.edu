<?php

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

namespace App\Repositories\Behaviors;

trait HandleApi
{
    /**
     * Get API endpoint. Replace brackets {name} with the 'name' attribute value (usually datahub_id)
     *
     * This way you can define an endpoint like:
     * protected $endpoint = '/api/v1/exhibitions/{datahub_id}/artwork/{id}';
     *
     * And the elements will be dinamically replaced with eloquent values
     *
     * @return string
     */
    public function getEndpoint()
    {
        return preg_replace_callback('!\{(\w+)\}!', function($matches) {
            $name = $matches[1];
            return $this->$name;
        }, $this->endpoint);
    }

    /**
     * Perform a request to the API client.
     * TODO: Add error controls and more configurations
     *
     * @return mixed
     */
    protected function request($params = [])
    {
        $client = \App::make('ApiClient');
        $response = $client->request('GET', $this->getEndpoint(), $params);

        return $response->data;
    }


    public function get($with = [], $scopes = [], $orders = [], $perPage = 20, $forcePagination = false)
    {
        $results = parent::get($with, $scopes, $orders, $perPage, $forcePagination);

        // Collect ids
        $ids = join(array_filter($results->pluck('datahub_id')->toArray()), ',');

        // Call the API
        $apiResults = $this->request(['query' => ['ids' => $ids]]);

        // Augment models
        foreach($results as &$item) {
            foreach($apiResults as $apiItem) {
                if ($apiItem->id == $item->datahub_id) {
                    $item->augmentEntity($apiItem);
                    break;
                }
            }
        }

        return $results;
    }

}
