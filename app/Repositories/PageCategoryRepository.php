<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\PageCategory;

class PageCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(PageCategory $model)
    {
        $this->model = $model;
    }

}
