<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\FeeCategory;

class FeeCategoryRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(FeeCategory $model)
    {
        $this->model = $model;
    }
}
