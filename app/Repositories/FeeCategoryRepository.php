<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\FeeCategory;

class FeeCategoryRepository extends ModuleRepository
{
    public function __construct(FeeCategory $model)
    {
        $this->model = $model;
    }
}
