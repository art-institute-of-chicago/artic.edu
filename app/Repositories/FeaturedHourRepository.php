<?php

namespace App\Repositories;


use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\FeaturedHour;

class FeaturedHourRepository extends ModuleRepository
{
    

    public function __construct(FeaturedHour $model)
    {
        $this->model = $model;
    }
}
