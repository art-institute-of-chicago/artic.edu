<?php

namespace App\Http\Controllers;

use App\Models\Event;

use App\Repositories\EventRepository;

class EventController extends Controller
{
    public function index(EventRepository $repository)
    {
        $events = $repository->getByRange(request('start_date'), request('end_date'));

        foreach($events as $event) {
            echo "{$event->date} - {$event->title} <br>";
        }

        die();
    }

}
