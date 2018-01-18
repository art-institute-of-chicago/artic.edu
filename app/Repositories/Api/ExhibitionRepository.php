<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Exhibition;

class ExhibitionRepository extends ModuleRepository
{
    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

}
