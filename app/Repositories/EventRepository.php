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

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        $this->updateBrowser($object, $fields, 'sponsors');
        $this->updateBrowser($object, $fields, 'events');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        $fields['browsers']['sponsors'] = $this->getFormFieldsForBrowser($object, 'sponsors', 'general');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'whatson');

        return $fields;
    }

    public function getEventTypesList() {
        return collect($this->model::$eventTypes);
    }

}
