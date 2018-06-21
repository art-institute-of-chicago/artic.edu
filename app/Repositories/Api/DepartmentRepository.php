<?php

namespace App\Repositories\Api;

use App\Models\Api\Department;
use App\Repositories\Api\BaseApiRepository;

class DepartmentRepository extends BaseApiRepository
{

    public function __construct(Department $model)
    {
        $this->model = $model;
    }

}
