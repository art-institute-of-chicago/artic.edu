<?php

namespace App\Repositories\Api;

use App\Models\Api\WaitTime;
use App\Repositories\Api\BaseApiRepository;

class WaitTimeRepository extends BaseApiRepository
{

    public function __construct(WaitTime $model)
    {
        $this->model = $model;
    }

}
