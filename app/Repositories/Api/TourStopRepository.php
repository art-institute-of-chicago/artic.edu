<?php

namespace App\Repositories\Api;

use App\Models\Api\TourStop;

class TourStopRepository extends BaseApiRepository
{
    public function __construct(TourStop $model)
    {
        $this->model = $model;
    }
}
