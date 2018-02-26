<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\ModuleRepository;
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
