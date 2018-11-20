<?php

namespace App\Repositories\Api;

use App\Models\Api\DigitalLabel;
use App\Repositories\Api\BaseApiRepository;

class DigitalLabelRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

}
