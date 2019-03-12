<?php

namespace App\Repositories\Api;

use App\Models\Api\TourStop;
use App\Repositories\Api\BaseApiRepository;

class TourStopRepository extends BaseApiRepository
{

    public function __construct(TourStop $model)
    {
        $this->model = $model;
    }

}
