<?php

namespace App\Repositories\Api;

use App\Models\Api\DigitalLabel;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\EventRepository;

use App\Models\Api\Search;

class DigitalLabelRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

    // Show data, moved here to allow preview
    // public function getShowData($item, $slug = null, $previewPage = null)
    // {
    //     $collection = app(EventRepository::class)->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE);
    //     $relatedEventsByDay = app(EventRepository::class)->groupByDate($collection);

    //     return [
    //         'contrastHeader' => $item->present()->contrastHeader,
    //         'item' => $item,
    //         'relatedEventsByDay' => $relatedEventsByDay,
    //     ];
    // }

    // public function searchApi($string, $perPage = null, $time = null)
    // {
    //     $search  = Search::query()->search($string)->resources(['digitalLabels']);

    //     // TODO: `upcoming` and `past` might be dead code. Remove..?
    //     if ($time == 'upcoming') {
    //         $search->exhibitionUpcoming();
    //     } elseif ($time == 'past') {
    //         $search->exhibitionHistory();
    //     } else {
    //         $search->exhibitionGlobal();
    //     }

    //     $results = $search->getPaginatedModel($perPage, \App\Models\Api\DigitalLabel::SEARCH_FIELDS);

    //     return $results;
    // }

}
