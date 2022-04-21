<?php

namespace App\Repositories;

use App\Models\BuildingClosure;

class BuildingClosureRepository extends ModuleRepository
{
    public function __construct(BuildingClosure $model)
    {
        $this->model = $model;
    }
}
