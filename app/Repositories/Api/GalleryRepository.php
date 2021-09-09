<?php

namespace App\Repositories\Api;

use App\Models\Api\Gallery;

class GalleryRepository extends BaseApiRepository
{
    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }
}
