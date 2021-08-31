<?php

namespace App\Repositories;

use App\Models\DateRule;

class DateRuleRepository extends ModuleRepository
{
    public function __construct(DateRule $model)
    {
        $this->model = $model;
    }
}
