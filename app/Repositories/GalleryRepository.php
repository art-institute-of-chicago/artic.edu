<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Gallery;
use App\Repositories\Api\BaseApiRepository;

class GalleryRepository extends BaseApiRepository
{
    use HandleMedias;

    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }
}
