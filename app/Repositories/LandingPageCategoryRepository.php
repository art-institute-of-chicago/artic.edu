<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\LandingPageCategory;

class LandingPageCategoryRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(LandingPageCategory $model)
    {
        $this->model = $model;
    }
}
