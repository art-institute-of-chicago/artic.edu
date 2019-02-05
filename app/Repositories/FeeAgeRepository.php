<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\FeeAge;

class FeeAgeRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(FeeAge $model)
    {
        $this->model = $model;
    }
}
