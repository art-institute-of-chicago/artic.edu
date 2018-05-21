<?php

namespace App\Repositories\Api;

use App\Models\Api\CategoryTerm;
use App\Repositories\Api\BaseApiRepository;

class CategoryTermRepository extends BaseApiRepository
{
    public function __construct(CategoryTerm $model)
    {
        $this->model = $model;
    }

}
