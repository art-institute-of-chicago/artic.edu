<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\FeaturedHour;

class FeaturedHourRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(FeaturedHour $model)
    {
        $this->model = $model;
    }
}
