<?php

namespace App\Repositories\Api;

use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class SearchRepository extends BaseApiRepository
{
    const ALL = 100;

    public function __construct(Search $model)
    {
        $this->model = $model;
    }

    public function forSearchQuery($string, $perPage = null, $columns = [], $pageName = 'page', $page = null, $options = [])
    {
        // Build the search query
        $search = $this->model->search($string)
            ->resources(['artworks', 'exhibitions', 'artists', 'agents', 'events', 'articles', 'digital-catalogs', 'printed-catalogs', 'generic-pages', 'research-guides', 'press-releases'])
            ->aggregationType();

        // Perform the query
        $results = $search->getSearch($perPage, $columns, $pageName, $page, $options);

        return $results;
    }

}
