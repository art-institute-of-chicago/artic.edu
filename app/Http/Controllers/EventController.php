<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Models\Page;
use App\Models\Event;
use Carbon\Carbon;
use View;

class EventController extends FrontController
{
    protected $repository;

    const PER_PAGE = 10;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
        View::share('eventTypesLinks', $this->generateEventTypes());

        parent::__construct();
    }

    public function index($upcoming = false)
    {
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $collection = $this->repository->getEventsByDateGrouped(request('start'), request('end'), request('time'), request('type'), self::PER_PAGE);

        return view('site.events', [
            'page' => $page,
            'eventsByDay' => $collection,
        ]);
    }

    public function show($id)
    {
        $item = $this->repository->getById($id);

        return view('site.eventDetail', [
            'item' => $item
        ]);
    }

    protected function generateEventTypes()
    {
        $links = [];

        foreach (Event::$eventTypes as $key => $type) {
            array_push($links, ['href' => route('events', array_merge(request()->all(), ['type' => $key])), 'label' => $type]);
        }

        return $links;
    }

}
