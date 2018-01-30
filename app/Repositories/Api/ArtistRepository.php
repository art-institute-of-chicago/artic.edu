<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artist;
use App\Repositories\Api\BaseApiRepository;

class ArtistRepository extends BaseApiRepository
{
    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

}
