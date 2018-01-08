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

        return $response;
    }


    public function get($with = [], $scopes = [], $orders = [], $perPage = 20, $forcePagination = false)
    {
        $results = parent::get($with, $scopes, $orders, $perPage, $forcePagination);

        // Collect ids
        $ids = join(array_filter($results->pluck('datahub_id')->toArray()), ',');

        // Call the API
        $params = ['query' => ['ids' => $ids]];
        $apiResults = $this->request($params);

        if ($apiResults->status == 200) {
            // Augment models
            foreach($results as &$item) {
                foreach($apiResults as $apiItem) {
                    if ($apiItem->id == $item->datahub_id) {
                        $item->augmentEntity($apiItem);
                        break;
                    }
                }
            }
        } else {
            $message = $this->getEndpoint() . ' - Parameters: '. json_encode($params) . ' Status: ' . $apiResults->body->status . " \n";
            $message .= get_class($this) . " - " . $apiResults->body->detail;
            \Log::error($message);
        }

        return $results;
    }

    public function getById($id, $with = [], $withCount = [])
    {
        $resource = parent::getById($id, $with, $withCount);
        if ($resource)
            $resource->refreshApi();

        return $resource;
    }

}
