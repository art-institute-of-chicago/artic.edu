<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\PageCategory;

class PageCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(PageCategory $model)
    {
        $this->model = $model;
    }

}
