<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Artist;

class ArtistRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

}
