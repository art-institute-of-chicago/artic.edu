<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artwork;

class ArtworkRepository extends ModuleRepository
{
    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

}
