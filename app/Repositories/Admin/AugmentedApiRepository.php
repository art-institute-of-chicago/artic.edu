<?php

/**
 * DEPRECATED:
 * To be replaced with the opposite. Load API listings and replace them with
 * augmented elements
 *
 */


namespace App\Repositories\Admin;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApi;

class AugmentedApiRepository extends ModuleRepository
{
    use HandleApi;

    /**
     * Load records normally and then scrap all datahub_ids, call the API and augment
     * the objects with the found data
     *
     */
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
                foreach($apiResults->body->data as $apiItem) {
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
