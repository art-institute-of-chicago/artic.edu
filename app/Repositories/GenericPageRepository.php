<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
// use A17\CmsToolkit\Repositories\Behaviors\HandleTranslations;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\GenericPage;
use DB;

class GenericPageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions; // HandleTranslations,

    public function __construct(GenericPage $model)
    {
        $this->model = $model;
    }

    public function setNewOrder($ids)
    {
        if (is_array(array_first($ids))) {
            DB::transaction(function () use ($ids) {
                Page::saveTreeFromIds($ids);
            }, 3);
        } else {
            parent::setNewOrder($ids);
        }
    }


}
