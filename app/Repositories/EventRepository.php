<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\Behaviors\HandleRepeaters;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleRecurrence;
use App\Models\Event;

class EventRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleRecurrence;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);
        $this->updateBrowser($object, $fields, 'sponsors');
        $this->updateBrowser($object, $fields, 'events');

        $this->updateRepeater($object, $fields, 'dateRules', 'DateRule');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        // $fields = $this->getFormFieldsForMultiSelect($fields, 'siteTags', 'id');

        $fields['browsers']['sponsors'] = $this->getFormFieldsForBrowser($object, 'sponsors', 'general');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'whatson');

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'dateRules', 'DateRule');

        return $fields;
    }

    public function getEventTypesList() {
        return collect($this->model::$eventTypes);
    }

    public function getEventLayoutsList() {
        return collect($this->model::$eventLayouts);
    }

}
