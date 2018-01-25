<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artist;

class ArtistRepository extends ModuleRepository
{
    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

}
