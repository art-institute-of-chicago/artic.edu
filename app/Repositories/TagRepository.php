<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Tag;

class TagRepository extends ModuleRepository
{
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

}
