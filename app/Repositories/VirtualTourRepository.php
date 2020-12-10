<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\VirtualTour;

class VirtualTourRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(VirtualTour $model)
    {
        $this->model = $model;
    }
}
