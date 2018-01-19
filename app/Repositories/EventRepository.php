<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Event;

class EventRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        // $this->hydrateOrderedBelongsTomany($object, $fields, 'events', 'position', 'Event');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        return $fields;
    }

}
