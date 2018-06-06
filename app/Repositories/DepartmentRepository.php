<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Department;
use App\Repositories\Api\BaseApiRepository;

class DepartmentRepository extends BaseApiRepository
{
    use HandleMedias;

    public function __construct(Department $model)
    {
        $this->model = $model;
    }

}
