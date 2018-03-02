<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\ModuleRepository;
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
