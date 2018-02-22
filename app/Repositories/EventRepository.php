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
use Carbon\Carbon;

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

    public function getEventsByDateGrouped($startDate, $endDate = null, $perPage = null, $page = null)
    {
        $query = $this->model->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', $startDate);

        if ($endDate) {
            $query->where('event_metas.date_end', '<=', $endDate);
        }

        $query->orderBy('event_metas.date', 'ASC');

        $results = $query->paginate($perPage, ['*'], 'page', $page);
        return $results->groupBy(function($item) {
          return $item->date->format('Y-m-d');
        });
    }

    public function getRelatedEventsByDay($object, $perPage = 3) {
        if ($object->events()->count() == 0) { return null; }

        $ids = $object->events->pluck('id');

        $query = $this->model->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', Carbon::today());
        $query->whereIn('id', $ids);
        $query->orderBy('event_metas.date', 'ASC');

        $results = $query->paginate($perPage);
        return $results->groupBy(function($item) {
          return $item->date->format('Y-m-d');
        });
    }

    public function getRelatedEventsCount($object) {
        $query = $object->events()->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', Carbon::today());

        return $query->count();
    }

}
