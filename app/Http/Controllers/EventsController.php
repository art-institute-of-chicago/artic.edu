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

    public const PER_PAGE = 10;

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
                $subtitle = 'These are events related to ' . EventProgram::find(request('program'))->name . '.';
            }
        } else {
            // Divide the collection by normal events and ongoing ones
            $ongoing = $collection->filter(function ($item) {
                return ($item->date <= Carbon::now()) && ($item->date_end_time > Carbon::now());
            });
            $recurrent = $collection->filter(function ($item) {
                return $item->date > Carbon::now();
            });

            // Show ongoing events as regular if there's no more events for the day
            if ($recurrent->isEmpty() && !$ongoing->isEmpty()) {
                $recurrent = $ongoing;
                $ongoing = null;
            }

            $eventsByDay = $this->repository->groupByDate($recurrent);

            // Check if the dates of $ongoing events are in the $eventsByDay array
            $ongoing->each(function ($item) use ($eventsByDay) {
                $keys = $eventsByDay->keys();

                if (!$keys->contains($item->date->format('Y-m-d'))) {
                    $eventsByDay->prepend([], $item->date->format('Y-m-d'));
                }
            });
            $eventsByDay = $eventsByDay->sortKeys();
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

        // @see https://ical.poerschke.nrw/docs/
        // 1. Create Event domain entities
        $vEvents = [];
        $vTimezone = \Eluceo\iCal\Domain\Entity\TimeZone::createFromPhpDateTimeZone(new \DateTimeZone('America/Chicago'));

        foreach ($event->all_dates as $dates) {
            if ($dates['date'] > Carbon::now()) {
                $vEvent = new \Eluceo\iCal\Domain\Entity\Event();
                $vEvent->setSummary($event->title);
                $vEvent->setOccurrence(
                    new \Eluceo\iCal\Domain\ValueObject\TimeSpan(
                        ($dates['date'] ? new \Eluceo\iCal\Domain\ValueObject\DateTime($dates['date']->toDate(), false) : null),
                        ($dates['date_end'] ? new \Eluceo\iCal\Domain\ValueObject\DateTime($dates['date_end']->toDate(), false) : null),
                    )
                );
                $vEvents[] = $vEvent;
            }
        }

        // 2. Create Calendar domain entity
        $vCalendar = new \Eluceo\iCal\Domain\Entity\Calendar($vEvents);
        $vCalendar->addTimeZone(\Eluceo\iCal\Domain\Entity\TimeZone::createFromPhpDateTimeZone(new \DateTimeZone('America/Chicago')));

        // 3. Transform domain entity into an iCalendar component
        $componentFactory = new \Eluceo\iCal\Presentation\Factory\CalendarFactory();
        $content = $componentFactory->createCalendar($vCalendar);

        $headers = [
            'Content-type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $event->title . '.ics"',
        ];

        return \Response::make($content, 200, $headers);
    }

    protected function collection()
    {
        return $this->repository->getEventsFiltered(request('start'), request('end'), request('time'), request('type'), request('audience'), request('program'), self::PER_PAGE, request('page'));
    }

    protected function isFiltered()
    {
        return !empty(request()->only('start', 'end', 'time', 'type', 'audience', 'page', 'program'));
    }

    protected function show($id, $slug = null)
    {
        $item = $this->repository->published()->findOrFail((int) $id);

        $canonicalPath = route('events.show', $item);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->short_description ?: $item->list_description);
        $this->seo->setImage($item->imageFront('hero'));

        if (!$item->is_future || $item->is_private) {
            $this->seo->nofollow = true;
            $this->seo->noindex = true;
        }

        return view('site.events.detail', [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'item' => $item,
            'contrastHeader' => $item->present()->contrastHeader,
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
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
                'href' => route('events', array_merge(request()->all(), ['type' => $key])),
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
                'href' => route('events', array_merge(request()->all(), ['audience' => $key])),
                'label' => $audience
            ]);
        }

        return $links;
    }

    protected function setPageMetaData($item)
    {
        return [
            'type' => 'event',
            'date' => ($next = $item->nextOccurrence)
                ? $next->date->toDateString()
                : null,
            'time' => ($next)
                ? $next->date->format('g:ia') . '-' . $next->date_end->format('g:ia')
                : null,
            'location' => $item->location,
            'registration-required' => $item->is_registration_required,
        ];
    }
}
