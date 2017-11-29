<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Page;

class PageRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        // $this->hydrateOrderedBelongsTomany($object, $fields, 'featuredWorks', 'position', 'Work');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeExhibitions', 'position', 'Exhibition');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        // $this->updateOrderedBelongsTomany($object, $fields, 'featuredWorks');
        $this->updateOrderedBelongsTomany($object, $fields, 'homeExhibitions');
        parent::afterSave($object, $fields);
    }

    public function byName($name, $with = [])
    {
        $type = array_search($name, $this->model::$types);
        return $this->model->whereType($type)->with($with)->first();
    }
}
