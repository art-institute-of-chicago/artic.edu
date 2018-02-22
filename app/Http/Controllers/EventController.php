<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;
use App\Models\Page;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    public function index()
    {
        // Grouped by day
        $groups = $this->repository->getEventsByDateGrouped(Carbon::today());

        // Not grouped by day, just sorted
        // $events = $this->repository->getByRange(request('start_date'), request('end_date'));

        foreach($groups as $date => $events) {
            echo "DATE: {$date} <br> <br>";
            foreach($events as $event) {
                echo "{$event->date->format('Y-m-d h:i l')} - {$event->title} <br>";
            }

            echo "-----<br> <br>";
        }

        die();
    }

    public function show($id)
    {
        $item = $this->repository->getById($id);

        return view('site.eventDetail', [
            'item' => $item
        ]);
    }

}
