<?php

namespace App\Repositories;

use App\Models\MagazineIssue;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;

class MagazineIssueRepository extends ModuleRepository
{
    use HandleSlugs, HandleBlocks, HandleMedias, HandleRevisions;

    public function __construct(MagazineIssue $model)
    {
        $this->model = $model;
    }
}
