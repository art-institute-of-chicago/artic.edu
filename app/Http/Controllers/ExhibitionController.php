<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\EventRepository;
use App\Models\Page;
use App\Models\Api\Exhibition;
use Carbon\Carbon;

class ExhibitionController extends FrontController
{
    protected $apiRepository;
    protected $eventRepository;

    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(ExhibitionRepository $repository, EventRepository $eventRepository)
    {
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

    public function show($id)
    {
        // The ID is a datahub_id not a local ID
        $item = $this->apiRepository->getById($id);

        $collection = $this->eventRepository->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE);
        $relatedEventsByDay = $this->eventRepository->groupByDate($collection);

        return view('site.exhibitionDetail', [
            'contrastHeader' => ($item->present()->headerType === 'hero'),
            'item' => $item,
            'relatedEventsByDay' => $relatedEventsByDay
        ]);
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
