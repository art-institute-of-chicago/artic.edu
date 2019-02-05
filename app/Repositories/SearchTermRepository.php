<?php

namespace App\Repositories;

use App\Models\SearchTerm;

class SearchTermRepository extends ModuleRepository
{

    public function __construct(SearchTerm $model)
    {
        $this->model = $model;
    }

}
