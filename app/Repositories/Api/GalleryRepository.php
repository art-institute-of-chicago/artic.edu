<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Gallery;
use App\Repositories\Api\BaseApiRepository;

class GalleryRepository extends BaseApiRepository
{
    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }

}
