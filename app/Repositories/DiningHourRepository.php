<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\DiningHour;

class DiningHourRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(DiningHour $model)
    {
        $this->model = $model;
    }
}
