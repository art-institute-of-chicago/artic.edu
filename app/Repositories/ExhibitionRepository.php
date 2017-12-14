<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use App\Models\Exhibition;

class ExhibitionRepository extends ModuleRepository
{
    use HandleRevisions, HandleMedias;

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
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        $this->updateOrderedBelongsTomany($object, $fields, 'events');
        $this->updateOrderedBelongsTomany($object, $fields, 'shopItems');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        return $fields;
    }

}
