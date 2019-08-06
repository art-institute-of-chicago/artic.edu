<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use App\Repositories\Behaviors\HandleRecurrence;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Models\Event;
use App\Models\EmailSeries;
use App\Models\Api\Search;
use App\Models\Api\TicketedEvent;
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

    /**
     * Some editors paste links to our sales site instead of browsing for the ticketed event.
     * Find and auto-attach the ticketed event if it's a match.
     */
    public function prepareFieldsBeforeSave($object, $fields)
    {
        if (isset($fields['rsvp_link']))
        {
            $isTicketedEvent = preg_match('/https*:\/\/sales\.artic\.edu\/Events\/Event\/([0-9]+)\?date=([0-9]+\/[0-9]+\/[0-9]+)/', $fields['rsvp_link'], $matches);

            if ($isTicketedEvent)
            {
                $ticketedEventId = $matches[1];
                $ticketedEvent = TicketedEvent::query()->find($ticketedEventId);

                // Roughshod way of checking if the ticketed event exists
                if (!isset($ticketedEvent->error))
                {
                    $fields['browsers']['ticketedEvent'] = [
                        [
                            'id' => $ticketedEvent->id,
                            'name' => $ticketedEvent->title,
                        ]
                    ];

                    // Do not update `rsvp_link` attribute
                    $fields['rsvp_link'] = null;
                }
            }
        }

        $relatedEmailSeries = [];

        if ($fields['add_to_event_email_series'] ?? false)
        {
            foreach (EmailSeries::all() as $series) {
                if (!($fields['email_series_' . $series->id] ?? false)) {
                    continue;
                }

                $pivotAttributes = [];

                foreach (['affiliate', 'member', 'sustaining_fellow', 'nonmember'] as $type) {
                    $pivotAttributes['override_' .$type] = $fields['email_series_' .$series->id .'_' .$type .'_override'] ?? false;
                    if ($pivotAttributes['override_' .$type]) {
                        if ($series->use_short_description) {
                            if (($fields['email_series_' .$series->id .'_' .$type .'_override_subtype'] ?? 'default') === 'custom') {
                                $pivotAttributes[$type .'_copy'] = $fields['email_series_' .$series->id .'_' .$type .'_copy'] ?? null;
                            } else {
                                $pivotAttributes[$type .'_copy'] = $fields['short_description'] ?? null;
                            }
                        } else {
                            $pivotAttributes[$type .'_copy'] = $fields['email_series_' .$series->id .'_' .$type .'_copy'] ?? null;
                        }
                        $pivotAttributes[$type .'_copy'] = $pivotAttributes[$type .'_copy'] ?: null;
                    } else {
                        $pivotAttributes[$type .'_copy'] = null;
                    }
                }

                if (count($pivotAttributes) > 0) {
                    $relatedEmailSeries[$series->id] = $pivotAttributes;
                }
            }
        }

        $object->emailSeries()->sync($relatedEmailSeries);

        return parent::prepareFieldsBeforeSave($object, $fields);
    }

    public function afterSave($object, $fields)
    {

        $this->updateBrowserApiRelated($object, $fields, ['ticketedEvent']);
        $this->updateBrowser($object, $fields, 'sponsors');
        $this->updateBrowser($object, $fields, 'events');

        $this->updateOrderedBelongsTomany($object, $fields, 'sponsors');

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

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'dateRules', 'DateRule');

        if (isset($fields['add_to_event_email_series']))
        {
            foreach ($object->emailSeries as $series) {
                $currentSeriesName = 'email_series_' . $series->id;
                $fields[$currentSeriesName] = true;

                foreach (['affiliate', 'member', 'sustaining_fellow', 'nonmember'] as $subFieldName) {
                    if ($series->pivot->{'override_' . $subFieldName}) {
                        $fields[$currentSeriesName . '_' . $subFieldName . '_override'] = true;

                        $copyForOverride = $series->pivot->{$subFieldName . '_copy'};
                        if ($copyForOverride) {
                            $fields[$currentSeriesName . '_' . $subFieldName . '_copy'] = $copyForOverride;
                        }
                    }
                }
            }
        }

        foreach (EmailSeries::all() as $series) {
            $currentSeriesName = 'email_series_' . $series->id;
            foreach (['affiliate', 'member', 'sustaining_fellow', 'nonmember'] as $subFieldName) {
                $currentSubField = $currentSeriesName . '_' . $subFieldName;

                if (empty($fields[$currentSubField . '_copy'])) {
                    if ($series->use_short_description) {
                        $fields[$currentSubField . '_copy'] = $fields['short_description'];
                    }
                }

                if ($series->use_short_description && $fields[$currentSubField . '_copy'] !== $fields['short_description']) {
                    // Prevents "Uncaught ReferenceError: custom is not defined"
                    $fields[$currentSubField . '_override_subtype'] = '"custom"';
                }
            }
        }

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

    public function getEventEntrancesList() {
        return collect($this->model::$eventEntrances);
    }

    public function groupByDate($collection)
    {
        if ($collection) {
            return $collection->groupBy(function($item) {
              return $item->date->format('Y-m-d');
            });
        }
    }

    // TODO: Consider defaulting $page to 1?
    public function getEventsFiltered($start = null, $end = null, $time = null, $type = null, $audience = null, $program = null, $perPage = 5, $page = null, $private = false, $callback = null)
    {
        $query = $this->model->newQuery();

        if (!$private) {
            // Do not show private events
            $query->notPrivate();
        }

        // Do not show draft events
        $query->published();

        if ($start) {
            $query->betweenDates($start, $end);
        }
        elseif ($program) {
            $query->year();
        }
        else {
            switch ($time) {
                case 'weekend':
                    $query->weekend();
                break;
                default:
                    if ($audience || $type) {
                        $query->sixMonths();
                    } else {
                        $query->default();
                    }
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

        if ($callback) {
            $callback($query);
        }

        return $query->paginate($perPage, ['events.*', 'event_metas.date', 'event_metas.date_end'], 'page', $page);
    }

    public function getRelatedEvents($object, $perPage = 3, $page = null) {
        if (!$object->events()) { return null; }
        if ($object->events()->count() == 0) { return null; }

        // Using the relationship directly, doesn't generate the correct Query.
        $ids = $object->events()->notPrivate()->get()->pluck('id');

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
        $search  = Search::query()->dateMin()->published()->public()->search($string)->resources(['events']);

        $results = $search->getSearch($perPage);

        return $results;
    }

}
