<?php

namespace App\Repositories;

use App\Models\Api\Search;

class PublicationsRepository
{
    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        $search = Search::query()->search($string)->published()->resources(["digital-catalogs", "printed-catalogs"]);

        $results = $search->getSearch($perPage, $columns, null, $page);

        return $results;
    }
}
