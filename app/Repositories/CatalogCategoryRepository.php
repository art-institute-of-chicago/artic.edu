<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\CatalogCategory;

class CatalogCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(CatalogCategory $model)
    {
        $this->model = $model;
    }

}
