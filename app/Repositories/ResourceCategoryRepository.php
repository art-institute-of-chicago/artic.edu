<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\ResourceCategory;

class ResourceCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(ResourceCategory $model)
    {
        $this->model = $model;
    }

}
