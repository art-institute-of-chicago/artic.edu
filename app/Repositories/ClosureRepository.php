<?php

namespace App\Repositories;

use App\Models\Closure;

class ClosureRepository extends ModuleRepository
{

    public function __construct(Closure $model)
    {
        $this->model = $model;
    }
}
