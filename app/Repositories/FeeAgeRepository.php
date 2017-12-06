<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\FeeAge;

class FeeAgeRepository extends ModuleRepository
{
    public function __construct(FeeAge $model)
    {
        $this->model = $model;
    }
}
