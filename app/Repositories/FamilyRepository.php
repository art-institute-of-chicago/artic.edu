<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleTranslations;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Family;

class FamilyRepository extends ModuleRepository
{
    use HandleTranslations, HandleMedias;

    public function __construct(Family $model)
    {
        $this->model = $model;
    }
}
