<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\ResourceCategory;

class ResourceCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(ResourceCategory $model)
    {
        $this->model = $model;
    }

}
