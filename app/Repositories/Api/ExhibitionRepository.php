<?php

namespace App\Repositories\Api;

use App\Models\Api\Exhibition;
use App\Repositories\EventRepository;

use App\Models\Api\Search;

class ExhibitionRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    /**
     * Upcoming exhibitions
     */
    public function upcoming()
    {
        return $this->model->query()->upcoming()->getSearch();
    }

    public function history($year = null, $q = null, $perPage = 20)
    {
        return $this->model->query()->history($year)->search($q)->getPaginatedModel($perPage, \App\Models\Api\Exhibition::SEARCH_FIELDS);
    }

    /**
     * Show data, moved here to allow preview
     */
    public function getShowData($item, $slug = null, $previewPage = null)
    {
        $collection = app(EventRepository::class)->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE);
        $relatedEventsByDay = app(EventRepository::class)->groupByDate($collection);

        return [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'relatedEventsByDay' => $relatedEventsByDay,
        ];
    }

    public function searchApi($string, $perPage = null, $time = null)
    {
        $search = Search::query()->search($string)->resources(['exhibitions']);

        // WEB-2264: `upcoming` and `past` might be dead code. Remove?
        if ($time == 'upcoming') {
            $search->exhibitionUpcoming();
        } elseif ($time == 'past') {
            $search->exhibitionHistory();
        } else {
            $search->exhibitionGlobal();
        }

        $results = $search->getPaginatedModel($perPage, \App\Models\Api\Exhibition::SEARCH_FIELDS);

        return $results;
    }
}
