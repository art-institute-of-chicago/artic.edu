<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\ExperienceImage;

class ExperienceImageRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(ExperienceImage $model)
    {
        $this->model = $model;
    }
}
