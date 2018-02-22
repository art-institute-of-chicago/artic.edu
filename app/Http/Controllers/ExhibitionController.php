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

    public function __construct(ExhibitionRepository $repository, EventRepository $eventRepository)
    {
        $this->apiRepository = $repository;
        $this->eventRepository = $eventRepository;

        parent::__construct();
    }

    public function index(ExhibitionRepository $repository)
    {
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $collection = $page->apiModels('exhibitionsCurrent', 'Exhibition');
        $events     = $this->eventRepository->getEventsByDateGrouped(Carbon::today(), Carbon::tomorrow());

        return view('site.exhibitions', [
            'page' => $page,
            'collection' => $collection,
            'eventsByDay' => $events
        ]);
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

}
