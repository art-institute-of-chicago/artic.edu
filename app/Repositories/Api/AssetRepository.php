<?php

namespace App\Repositories\Api;

use App\Models\Api\Asset;

class AssetRepository extends BaseApiRepository
{
    const ALL = 100;

    public function __construct(Asset $model)
    {
        $this->model = $model;
    }
}
