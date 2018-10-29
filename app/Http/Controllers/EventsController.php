<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\EventProgram;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use View;

class EventsController extends FrontController
{

    protected $repository;
    protected $moduleName = 'events';

    const PER_PAGE = 10;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
        View::share('eventTypesLinks', $this->generateEventTypes());
        View::share('eventAudiencesLinks', $this->generateEventAudiences());

        parent::__construct();
    }

    public function index()
    {
        $this->seo->setTitle('Events');
        $this->seo->setDescription("Looking for things to do this weekend? Find Chicago's best events—family art making, tours, performances, lectures, workshops & more.");

        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();
        $collection = $this->collection();
        $subtitle = null;

        // If it's filtered just show everything instead of dividing the listing on ongoing
        if ($this->isFiltered()) {
            $ongoing = null;
            $eventsByDay = $this->repository->groupByDate($collection);
            if (request('program')) {
                $subtitle = "These are events related to " .EventProgram::find(request('program'))->name .".";
            }
        } else {
            // Divide the collection by normal events and ongoing ones
            $ongoing = $collection->filter(function ($item) {
                return ($item->date <= Carbon::now()) && ($item->date_end > Carbon::now());
            });
            $recurrent = $collection->filter(function ($item) {
                return ($item->date > Carbon::now());
            });

            // Show ongoing events as regular if there's no more events for the day
            if ($recurrent->isEmpty() && !$ongoing->isEmpty()) {
                $recurrent = $ongoing;
                $ongoing = null;
            }

            $eventsByDay = $this->repository->groupByDate($recurrent);
        }

        return view('site.events.index', [
            'page' => $page,
            'subtitle' => $subtitle,
            'eventsByDay' => $eventsByDay,
            'collection' => $collection,
            'ongoing' => $ongoing,
            'primaryNavCurrent' => 'exhibitions_and_events',
        ]);
    }

    public function indexMore()
    {
        $collection = $this->collection();
        $eventsByDay = $this->repository->groupByDate($collection);

        $view['html'] = view('site.events._items', [
            'eventsByDay' => $eventsByDay,
        ])->render();

        if ($collection->hasMorePages()) {
            $view['page'] = request('page');
        }

        return $view;
    }

    public function ics($id)
    {
        $event = Event::findOrFail($id);

        $vCalendar = new \Eluceo\iCal\Component\Calendar($event->title);

        foreach ($event->all_dates as $dates) {
            if ($dates['date'] > Carbon::now()) {
                $vEvent = new \Eluceo\iCal\Component\Event();
                $vEvent->setSummary($event->title);
                $vEvent->setDtStart($dates['date'])->setDtEnd($dates['date_end']);
                $vCalendar->addComponent($vEvent);
            }
        }

        $content = $vCalendar->render();

        $headers = [
            'Content-type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="' . $event->title . '.ics"',
        ];

        return \Response::make($content, 200, $headers);
    }

    protected function collection()
    {
        return $this->repository->getEventsFiltered(request('start'), request('end'), request('time'), request('type'), request('audience'), request('program'), self::PER_PAGE);
    }

    protected function isFiltered()
    {
        return !empty(request()->only('start', 'end', 'time', 'type', 'audience', 'page', 'program'));
    }

    protected function show($id, $slug = null)
    {
        $item = $this->repository->published()->findOrFail((Integer) $id);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('events.show', $item, false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?? $item->short_description ?? $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        return view('site.events.detail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'canonicalUrl' => route('events.show', $item),
        ]);
    }

    protected function generateEventTypes()
    {
        $links = [
            [
                'href' => route('events', request()->except('type')),
                'label' => 'All event types',
            ],
        ];

        foreach (Event::$eventTypes as $key => $type) {
            array_push($links, [
                'href'  => route('events', array_merge(request()->all(), ['type' => $key])),
                'label' => $type
            ]);
        }

        return $links;
    }

    protected function generateEventAudiences()
    {
        $links = [
            [
                'href' => route('events', request()->except('audience')),
                'label' => 'All audiences',
            ],
        ];

        foreach (Event::$eventAudiences as $key => $audience) {
            array_push($links, [
                'href'  => route('events', array_merge(request()->all(), ['audience' => $key])),
                'label' => $audience
            ]);
        }

        return $links;
    }

}
