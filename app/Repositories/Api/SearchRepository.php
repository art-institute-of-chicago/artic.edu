<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class SearchRepository extends BaseApiRepository
{
    public function __construct(Search $model)
    {
        $this->model = $model;
    }

}
