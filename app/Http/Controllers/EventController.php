<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Models\Page;
use Carbon\Carbon;

class EventController extends FrontController
{
    protected $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index($upcoming = false)
    {
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        // Today events
        $collection = $this->repository->getEventsByDateGrouped(Carbon::today(), Carbon::tomorrow(), 100);

        return view('site.events', [
            'page' => $page,
            'eventsByDay' => $collection
        ]);
    }

    public function show($id)
    {
        $item = $this->repository->getById($id);

        return view('site.eventDetail', [
            'item' => $item
        ]);
    }

}
