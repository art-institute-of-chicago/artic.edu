<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\EventRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;
use App\Models\Page;
use App\Models\Api\Exhibition;
use Carbon\Carbon;

class ExhibitionController extends Controller
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

        $events = $this->eventRepository->getEventsByDateGrouped(Carbon::today(), Carbon::tomorrow()->addDay(), 4);

        return view('site.exhibitions', [
            'page' => $page,
            'collection' => $collection,
            'eventsByDay' => $events,
            'upcoming' => $upcoming
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

        $relatedEventsByDay = $this->eventRepository->getRelatedEventsByDay($item);

        return view('site.exhibitionDetail', [
            'contrastHeader' => ($item->present()->headerType === 'hero'),
            'item' => $item,
            'relatedEventsByDay' => $relatedEventsByDay
        ]);
    }

    public function loadMoreRelatedEvents($id)
    {
        $item = $this->apiRepository->getById($id);
        $relatedEventsByDay = $this->eventRepository->getRelatedEventsByDay($item, self::RELATED_EVENTS_PER_PAGE, request('page'));

        // TODO: 1 load too many. Send an empty page when there aren't more events
        $page = $relatedEventsByDay->isEmpty() ? '' : request('page') + 1;

        return [
            'page' => $page,
            'html' => view('statics.exhibitions_load_more', [
                'items' => $relatedEventsByDay
            ])->render(),
        ];
    }

}
