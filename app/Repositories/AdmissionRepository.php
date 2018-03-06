<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Admission;

class AdmissionRepository extends ModuleRepository
{

    public function __construct(Admission $model)
    {
        $this->model = $model;
    }

}
