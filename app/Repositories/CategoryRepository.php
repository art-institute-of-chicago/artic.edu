<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Category;

class CategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

}
