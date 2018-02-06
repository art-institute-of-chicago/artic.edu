<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use A17\CmsToolkit\Http\Controllers\Front\Controller;

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
        $events = $this->repository->getByRange(request('start_date'), request('end_date'));

        foreach($events as $event) {
            echo "{$event->date->format('Y-m-d h:i l')} - {$event->title} <br>";
        }

        die();
    }

    public function show($id)
    {
        $item = $this->repository->getById($id);

        return view('site.article', [
            'article' => $item
        ]);
    }

}
