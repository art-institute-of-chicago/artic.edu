<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\WhatToExpect;

class WhatToExpectRepository extends ModuleRepository
{
    use HandleTranslations, HandleRevisions;

    public function __construct(WhatToExpect $model)
    {
        $this->model = $model;
    }
}
