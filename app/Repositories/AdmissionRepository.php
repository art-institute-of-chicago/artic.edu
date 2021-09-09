<?php

namespace App\Repositories;

use App\Models\Admission;

class AdmissionRepository extends ModuleRepository
{
    public function __construct(Admission $model)
    {
        $this->model = $model;
    }
}
