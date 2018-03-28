<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\ResearchGuide;

class ResearchGuideRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(ResearchGuide $model)
    {
        $this->model = $model;
    }
}
