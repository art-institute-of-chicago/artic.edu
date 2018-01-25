<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Exhibition;
use App\Repositories\Api\BaseApiRepository;

class ExhibitionRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks;

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'events', 'position', 'Event');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, 'exhibitions');
        $this->updateBrowser($object, $fields, 'events');

        $this->updateOrderedBelongsTomany($object, $fields, 'sponsors');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'siteTags', 'id');

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'whatson');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'whatson');

        return $fields;
    }

    public function getExhibitionTypesList() {
        return collect($this->model::$exhibitionTypes);
    }

}
