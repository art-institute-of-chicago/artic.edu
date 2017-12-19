<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRepeaters;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Page;

class PageRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleRepeaters;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeExhibitions', 'position', 'Exhibition');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeEvents', 'position', 'Event');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        // Homepage
        $this->updateOrderedBelongsTomany($object, $fields, 'homeExhibitions');
        $this->updateOrderedBelongsTomany($object, $fields, 'homeEvents');

        // Visits
        $this->updateRepeater($object, $fields, 'admissions', 'Admission');
        $this->updateRepeater($object, $fields, 'locations', 'Location');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'admissions', 'Admission');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'locations', 'Location');

        return $fields;
    }

    public function byName($name, $with = [])
    {
        $type = array_search($name, $this->model::$types);
        return $this->model->whereType($type)->with($with)->first();
    }
}
