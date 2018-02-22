<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Exhibition;
use App\Repositories\Api\BaseApiRepository;

class ExhibitionRepository extends BaseApiRepository
{
    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    // Upcoming exhibitions
    public function upcoming() {
        return $this->model->query()->upcoming()->getSearch();
    }

}
