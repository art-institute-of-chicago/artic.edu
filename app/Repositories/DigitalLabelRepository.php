<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\ModuleRepository;

use App\Repositories\Behaviors\HandleApiBlocks;
use App\Models\DigitalLabel;
use App\Repositories\Api\BaseApiRepository;

class DigitalLabelRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

}
