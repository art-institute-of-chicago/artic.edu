<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Video;

class VideoRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleFiles;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

}
