<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleRecurrence;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Models\Event;
use App\Models\Api\Search;
use Carbon\Carbon;

class EventRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleApiBlocks, HandleApiRelations, HandleBlocks, HandleRepeaters, HandleRecurrence {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {

        $this->updateBrowserApiRelated($object, $fields, ['ticketedEvent']);
        $this->updateBrowserApiRelated($object, $fields, ['ticketedEventType']);
        $this->updateBrowser($object, $fields, 'sponsors');
        $this->updateBrowser($object, $fields, 'events');

        $this->updateRepeater($object, $fields, 'dateRules', 'DateRule');

        $object->programs()->sync($fields['programs'] ?? []);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['sponsors'] = $this->getFormFieldsForBrowser($object, 'sponsors', 'exhibitions_events');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');
        $fields['browsers']['ticketedEvent'] = $this->getFormFieldsForBrowserApi($object, 'ticketedEvent', 'App\Models\Api\TicketedEvent', 'exhibitions_events', 'title', 'ticketedEvent');
        $fields['browsers']['ticketedEventType'] = $this->getFormFieldsForBrowserApi($object, 'ticketedEventType', 'App\Models\Api\TicketedEventType', 'exhibitions_events', 'title', 'ticketedEventType');

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'dateRules', 'DateRule');

        return $fields;
    }

    public function getEventTypesList() {
        return collect($this->model::$eventTypes);
    }

    public function getEventAudiencesList() {
        return collect($this->model::$eventAudiences);
    }

    public function getEventLayoutsList() {
        return collect($this->model::$eventLayouts);
    }

    public function groupByDate($collection)
    {
        if ($collection) {
            return $collection->groupBy(function($item) {
              return $item->date->format('Y-m-d');
            });
        }
    }

    public function getEventsFiltered($start = null, $end = null, $time = null, $type = null, $audience = null, $program = null, $perPage = 5, $page = null)
    {
        $query = $this->model->newQuery();

        // Do not show hidden or private events
        $query->notHidden()->notPrivate();

        if ($start) {
            $query->betweenDates($start, $end);
        } else {
            switch ($time) {
                case 'weekend':
                    $query->weekend();
                    break;
                // TODO: "Today" on the website uses `default`, so remove this..?
                case 'today':
                    $query->today();
                    break;
                default:
                    $query->default();
                    break;
            }
        }

        if ($type) {
            $query->byType($type);
        }

        if ($audience) {
            $query->byAudience($audience);
        }

        if ($program) {
            $query->byProgram($program);
        }

        return $query->paginate($perPage, ['events.*', 'event_metas.date', 'event_metas.date_end'], 'page', $page);
    }

    public function getRelatedEvents($object, $perPage = 3, $page = null) {
        if (!$object->events()) { return null; }
        if ($object->events()->count() == 0) { return null; }

        // Using the relationship directly, doesn't generate the correct Query.
        $ids = $object->events()->notHidden()->notPrivate()->get()->pluck('id');

        $query = $this->model->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', Carbon::today());
        $query->whereIn('events.id', $ids);
        $query->orderBy('event_metas.date', 'ASC');

        return $query->paginate($perPage, ['events.*', 'event_metas.date', 'event_metas.date_end'], 'page', $page);
    }

    public function getRelatedEventsCount($object) {
        $query = $object->events()->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', Carbon::today());

        return $query->count();
    }

    // Show data, moved here to allow preview
    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
        ];
    }

    public function searchApi($string, $perPage = null)
    {
        $search  = Search::query()->search($string)->resources(['events']);

        $results = $search->getSearch($perPage);

        return $results;
    }

}
