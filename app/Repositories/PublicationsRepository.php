<?php

namespace App\Repositories;

use App\Models\GenericPage;
use App\Models\Api\Search;

class PublicationsRepository
{
    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        $search  = Search::query()->search($string)->resources(['publications']);

        // Perform the query
        $results = $search->forPage($page, $perPage)->get($columns);

        return $results;
    }
}
