<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Http\Controllers\Front\ShowWithPreview;
use App\Repositories\EventRepository;
use App\Models\Page;
use App\Models\Event;
use Carbon\Carbon;
use View;

class EventsController extends FrontController
{
    use ShowWithPreview;

    protected $repository;
    protected $moduleName   = 'events';
    protected $showViewName = 'site.events.detail';

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
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();
        $collection  = $this->collection();

        // If it's filtered just show everything instead of dividing the listing on ongoing
        if ($this->isFiltered()) {
            $ongoing = null;
            $eventsByDay = $this->repository->groupByDate($collection);
        } else {
            // Divide the collection on normal events, and ongoing ones
            $ongoing = $collection->filter(function ($item) {
                return ($item->date <= Carbon::now()) && ($item->date_end > Carbon::now());
            });
            $recurrent = $collection->filter(function ($item) {
                return ($item->date > Carbon::now());
            });

            // Show ongoing events as regular if there's no more events for the day
            if ($recurrent->isEmpty() && !$ongoing->isEmpty()) {
                $recurrent = $ongoing;
                $ongoing   = null;
            }

            $eventsByDay = $this->repository->groupByDate($recurrent);
        }

        return view('site.events.index', [
            'page'        => $page,
            'eventsByDay' => $eventsByDay,
            'collection'  => $collection,
            'ongoing'     => $ongoing
        ]);
    }

    public function indexMore()
    {
        $collection  = $this->collection();
        $eventsByDay = $this->repository->groupByDate($collection);

        $view['html'] = view('site.events._items', [
            'eventsByDay' => $eventsByDay
        ])->render();

        if ($collection->hasMorePages())
            $view['page'] = request('page');

        return $view;
    }

    public function ics($id)
    {
        $event = $this->getItem($id);

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
            'Content-type'        => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="' . $event->title . '.ics"',
        ];

        return \Response::make($content, 200, $headers);


        // Response::make($ical)->header("Content-type","text/calendar; charset=utf-8")

        // return response()->download(;, $event->title . ".ics");
    }

    protected function collection()
    {
        return $this->repository->getEventsFiltered(request('start'), request('end'), request('time'), request('type'), request('audience'), self::PER_PAGE);
    }

    protected function isFiltered()
    {
        return !empty(request()->only('start', 'end', 'time', 'type', 'audience', 'page'));
    }

    // Show view has been moved to be used with the trait ShowWithPreview
    protected function showData($slug, $item)
    {
        return $this->repository->getShowData($item, $slug);
    }

    protected function getItem($id)
    {
        return $this->repository->find((Integer) $id);
    }

    protected function generateEventTypes()
    {
        $links = [
            [
                'href' => route('events', request()->except('type')),
                'label' => 'All event types'
            ]
        ];

        foreach (Event::$eventTypes as $key => $type) {
            array_push($links, ['href' => route('events', array_merge(request()->all(), ['type' => $key])), 'label' => $type]);
        }

        return $links;
    }

    protected function generateEventAudiences()
    {
        $links = [
            [
                'href' => route('events', request()->except('audience')),
                'label' => 'All audiences'
            ]
        ];

        foreach (Event::$eventAudiences as $key => $audience) {
            array_push($links, ['href' => route('events', array_merge(request()->all(), ['audience' => $key])), 'label' => $audience]);
        }

        return $links;
    }

}
