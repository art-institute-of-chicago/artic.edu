<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Http\Controllers\Front\ShowWithPreview;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\EventRepository;
use App\Models\Page;
use App\Models\Api\Exhibition;
use Carbon\Carbon;

class ExhibitionsController extends FrontController
{
    use ShowWithPreview;

    protected $apiRepository;
    protected $eventRepository;
    protected $moduleName = 'exhibitions';
    protected $showViewName = 'site.exhibitionDetail';

    public function __construct(ExhibitionRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->apiRepository = $repository;
        $this->eventRepository = $eventRepository;

        parent::__construct();
    }

    public function index($upcoming = false)
    {
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        if ($upcoming) {
            $collection = $this->apiRepository->upcoming();
        } else {
            $collection = $page->apiModels('exhibitionsCurrent', 'Exhibition');
        }

        $events = $this->eventRepository->getEventsFiltered(Carbon::today(), Carbon::tomorrow()->addDay(), null, null, null, 20);
        $eventsByDay = $this->eventRepository->groupByDate($events);

        return view('site.exhibitions', [
            'page' => $page,
            'collection'  => $collection,
            'eventsByDay' => $eventsByDay,
            'events'      => $events,
            'upcoming'    => $upcoming
        ]);
    }

    public function upcoming()
    {
        return $this->index(true);
    }

    // Show view has been moved to be used with the trait ShowWithPreview
    protected function showData($slug, $item)
    {
        return $this->apiRepository->getShowData($item, $slug);
    }

    protected function getItem($slug)
    {
        return $this->apiRepository->getById($slug);
    }

    public function loadMoreRelatedEvents($id)
    {
        $item = $this->apiRepository->getById($id);
        $collection = $this->eventRepository->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE, request('page'));
        $relatedEventsByDay = $this->eventRepository->groupByDate($collection);

        $view['html'] = view('statics.exhibitions_load_more', [
                'items' => $relatedEventsByDay
        ])->render();

        if ($collection->hasMorePages())
            $view['page'] = request('page');

        return $view;
    }

}
