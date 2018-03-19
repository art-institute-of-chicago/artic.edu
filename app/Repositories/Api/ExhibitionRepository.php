<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Exhibition;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\EventRepository;

class ExhibitionRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    // Upcoming exhibitions
    public function upcoming() {
        return $this->model->query()->upcoming()->getSearch();
    }

    public function history($year=null, $perPage=null) {
        return $this->model->query()->history($year)->getSearch();
    }

    // Show data, moved here to allow preview
    public function getShowData($item, $slug = null, $previewPage = null)
    {
        $collection = app(EventRepository::class)->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE);
        $relatedEventsByDay = app(EventRepository::class)->groupByDate($collection);

        return [
            'contrastHeader' => ($item->present()->headerType === 'hero'),
            'item' => $item,
            'relatedEventsByDay' => $relatedEventsByDay
        ];

        // 'previewingPageSlug' => $previewPage ? ($previewPage->id . '-' . str_slug($previewPage->title)) : false,
    }

}
