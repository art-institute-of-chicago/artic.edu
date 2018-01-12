<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\CategoryApi;

class CategoryApiRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(CategoryApi $model)
    {
        $this->model = $model;
    }

}
