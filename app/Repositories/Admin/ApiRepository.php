<?php

namespace App\Repositories\Admin;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApi;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiRepository extends ModuleRepository
{
    use HandleApi;

    public function get($with = [], $scopes = [], $orders = [], $perPage = 20, $forcePagination = false)
    {
        // TODO: Implement these queries for the API
        // $query = $this->model->with($with);
        // $query = $this->filter($query, $scopes);
        // $query = $this->order($query, $orders);

        $page = $page ?? LengthAwarePaginator::resolveCurrentPage();
        $params = [
            'query' => [
                'page'  => $page,
                'limit' => $perPage,
                // 'include' => 'a,b,c',
                // 'fields' => 'a,b,c'
            ]
        ];
        $apiResults = $this->request($params);

        // Create an array of models (not a collection yet)
        $items = $this->buildItems($apiResults->body->data);

        // Instantiate a paginator object
        return $this->buildPaginator($items, $apiResults->body->pagination, $perPage, $params);
    }

    /*
     * Build items from the response array into a model instances array
     */
    protected function buildItems($itemsResponse)
    {
        return $this->model->hydrate($itemsResponse);
    }

    /*
     * Create a regular paginator object using the collection and
     */
    protected function buildPaginator($items, $paginationData, $perPage, $params)
    {
        $offset = $paginationData->offset;
        $total  = $paginationData->total;
        $currentPage = $paginationData->current_page;

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $this->getEndpoint($params),
                'query' => $params
            ]
        );
    }
}
