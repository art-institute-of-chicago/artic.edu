<?php

namespace App\Repositories\Api;

use App\Models\Api\CategoryTerm;

class CategoryTermRepository extends BaseApiRepository
{
    public function __construct(CategoryTerm $model)
    {
        $this->model = $model;
    }
}
