<?php

namespace App\Repositories\Api;

use App\Models\Api\Exhibition;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\EventRepository;

use App\Models\Api\Search;

class ExhibitionRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    // Upcoming exhibitions
    public function upcoming()
    {
        return $this->model->query()->upcoming()->getSearch();
    }

    public function history($year = null, $q = null)
    {
        return $this->model->query()->history($year)->search($q)->getSearch();
    }

    // Show data, moved here to allow preview
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

    public function searchExhibitionEvents($string, $perPage = null, $columns = [], $pageName = 'page', $page = null, $options = [] )
    {
        $search  = Search::query()->search($string)->resources(['events', 'exhibitions']);

        // Perform the query
        $results = $search->getSearch($perPage, $columns, $pageName, $page, $options);

        return $results;
    }

}
