<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Department;
use App\Repositories\Api\BaseApiRepository;

class DepartmentRepository extends BaseApiRepository
{
    public function __construct(Department $model)
    {
        $this->model = $model;
    }

}
