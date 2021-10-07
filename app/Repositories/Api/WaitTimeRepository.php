<?php

namespace App\Repositories\Api;

use App\Models\Api\WaitTime;

class WaitTimeRepository extends BaseApiRepository
{
    public function __construct(WaitTime $model)
    {
        $this->model = $model;
    }
}
