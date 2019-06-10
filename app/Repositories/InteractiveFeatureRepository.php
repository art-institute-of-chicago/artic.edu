<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\InteractiveFeature;
use App\Repositories\Behaviors\HandleApiBlocks;
use Artisan;

class InteractiveFeatureRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    function __construct(InteractiveFeature $model)
    {
        $this->model = $model;
    }

    function afterSave($object, $fields)
    {
        parent::afterSave($object, $fields);
    }

    function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];
        return parent::getCountByStatusSlug($slug, $scope);
    }

}
