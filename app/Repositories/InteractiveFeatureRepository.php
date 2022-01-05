<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\InteractiveFeature;
use App\Models\Experience;

class InteractiveFeatureRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks;

    public function __construct(InteractiveFeature $model)
    {
        $this->model = $model;
    }

    public function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];

        return parent::getCountByStatusSlug($slug, $scope);
    }

    public function search($search)
    {
        return Experience::where('title', 'ILIKE', "%{$search}%")->published();
    }
}
