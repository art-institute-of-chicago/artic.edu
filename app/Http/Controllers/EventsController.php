<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\EventProgram;
use App\Repositories\EventRepository;
use App\Libraries\SchemaOrg\SchemaMapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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

            $programName = null;
            if (request()->filled('program') && $programName = EventProgram::find(request()->integer('program'))?->name) {
                $subtitle = 'These are events related to ' . $programName . '.';
            }

            $type = collect(Event::$eventTypes)->first(function ($value, $key) {
                return $key == request('type');
            });
            $audience = collect(Event::$eventAudiences)->first(function ($value, $key) {
                return $key == request('audience');
            });
            $titles = array_filter([
                'Events',
                request('start') ? Carbon::parse(request('start'))->toFormattedDateString() : null,
                request('end') ? Carbon::parse(request('end'))->toFormattedDateString() : null,
                Str::title(request('time')),
                $type,
                $audience,
                $programName,
                request('page') ? 'Page ' . request('page') : null,
            ]);

            $this->seo->setTitle(implode(', ', $titles));
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
            $ongoing?->each(function ($item) use ($eventsByDay) {
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

        return Response::make($content, 200, $headers);
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

        $this->addJsonLd($item);
        $this->addBreadcrumbs([
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Events', 'url' => route('events')],
            ['label' => $item->title],
        ]);

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

    /**
     * The schema.org definition for the given model.
     *
     * Shared defaults (e.g. inLanguage) come from the parent; page-specific
     * properties defined here are merged over them.
     *
     * @param mixed $model The model to map.
     *
     * @return array<string, mixed>
     */
    protected function jsonLdDefinition(mixed $model): array
    {
        $literal = static fn (mixed $value) => static fn () => $value;

        $toSeconds = static fn (\DateInterval $interval): int => (($interval->d * 24 + $interval->h) * 60 + $interval->i) * 60 + $interval->s;

        $fromSeconds = static function (int $seconds): string {
            $hours = intdiv($seconds, 3600);
            $minutes = intdiv($seconds % 3600, 60);
            $remainingSeconds = $seconds % 60;

            $time = ($hours > 0 ? $hours . 'H' : '') . ($minutes > 0 ? $minutes . 'M' : '') . ($remainingSeconds > 0 ? $remainingSeconds . 'S' : '');

            return 'PT' . ($time !== '' ? $time : '0S');
        };

        $formatDuration = static function (\DateInterval $interval): string {
            $date = ($interval->y > 0 ? $interval->y . 'Y' : '') . ($interval->m > 0 ? $interval->m . 'M' : '') . ($interval->d > 0 ? $interval->d . 'D' : '');
            $time = ($interval->h > 0 ? $interval->h . 'H' : '') . ($interval->i > 0 ? $interval->i . 'M' : '') . ($interval->s > 0 ? $interval->s . 'S' : '');

            return 'P' . $date . ($date !== '' || $time !== '' ? 'T' : '') . $time;
        };

        $eventDuration = static function ($m) use ($toSeconds, $fromSeconds, $formatDuration): ?string {
            $start = $m->date_start ?? null;
            $end = $m->date_end ?? null;

            if ($start instanceof \DateTimeInterface && $end instanceof \DateTimeInterface) {
                $interval = $start->diff($end);

                return $interval->invert === 0 ? $formatDuration($interval) : null;
            }

            try {
                $startTime = $m->start_time ?? null;
                $endTime = $m->end_time ?? null;
            } catch (\Throwable $e) {
                return null;
            }

            if (!is_string($startTime) || !is_string($endTime) || $startTime === '' || $endTime === '') {
                return null;
            }

            try {
                $seconds = $toSeconds(new \DateInterval($endTime)) - $toSeconds(new \DateInterval($startTime));

                if ($seconds <= 0) {
                    return null;
                }

                return $fromSeconds($seconds);
            } catch (\Throwable $e) {
                return null;
            }
        };

        $eventAudience = static function ($m) {
            $labels = [];

            try {
                $primary = $m->audience ?? null;

                if (is_numeric($primary) && isset(Event::$eventAudiences[(int) $primary])) {
                    $labels[] = Event::$eventAudiences[(int) $primary];
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures; fall through to alt audiences
            }

            try {
                $altAudiences = $m->alt_audiences ?? null;

                if (is_array($altAudiences)) {
                    foreach ($altAudiences as $audience) {
                        $id = is_array($audience) ? ($audience['id'] ?? null) : ($audience->id ?? null);

                        if (is_numeric($id) && isset(Event::$eventAudiences[(int) $id])) {
                            $labels[] = Event::$eventAudiences[(int) $id];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            $labels = array_values(array_unique(array_filter($labels)));

            if (empty($labels)) {
                return null;
            }

            $audience = array_map(
                static fn (string $label) => ['@type' => 'Audience', 'audienceType' => $label],
                $labels
            );

            return count($audience) === 1 ? $audience[0] : $audience;
        };

        $eventKeywords = static function ($m) {
            $labels = [];

            try {
                $eventType = $m->event_type ?? null;

                if (is_numeric($eventType) && isset(Event::$eventTypes[(int) $eventType])) {
                    $labels[] = Event::$eventTypes[(int) $eventType];
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            try {
                $altTypes = $m->alt_types ?? null;

                if (is_array($altTypes)) {
                    foreach ($altTypes as $type) {
                        $id = is_array($type) ? ($type['id'] ?? null) : ($type->id ?? null);

                        if (is_numeric($id) && isset(Event::$eventTypes[(int) $id])) {
                            $labels[] = Event::$eventTypes[(int) $id];
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore accessor failures
            }

            $labels = array_values(array_unique(array_filter($labels)));

            return empty($labels) ? null : implode(', ', $labels);
        };

        $eventLocation = static function ($m, $mapper) {
            if (!empty($m->is_virtual_event)) {
                return [
                    '@type' => 'VirtualLocation',
                    'url' => $m->virtual_event_url ?? null,
                ];
            }

            if (empty($m->location)) {
                return null;
            }

            return [
                '@type' => 'Place',
                'name' => $m->location,
                'address' => $mapper->museumAddress(),
            ];
        };

        $eventOffers = static function ($m) {
            $offer = ['@type' => 'Offer'];

            $url = null;

            if (!empty($m->rsvp_link)) {
                $url = $m->rsvp_link;
            } elseif (!empty($m->is_ticketed)) {
                try {
                    $url = $m->buy_tickets_link ?? null;
                } catch (\Throwable $e) {
                    $url = null;
                }
            }

            if (is_string($url) && $url !== '') {
                $offer['url'] = $url;
            }

            $offer['availability'] = !empty($m->is_sold_out)
                ? 'https://schema.org/SoldOut'
                : 'https://schema.org/InStock';

            if (!empty($m->is_free)) {
                $offer['price'] = '0';
                $offer['priceCurrency'] = 'USD';
            }

            return count($offer) > 1 ? $offer : null;
        };

        return array_merge(
            parent::jsonLdDefinition($model),
            [
                '@type' => 'Event',
                'description' => SchemaMapper::text('short_description', 'list_description'),
                'startDate' => SchemaMapper::iso('date_start'),
                'endDate' => SchemaMapper::iso('date_end'),
                'doorTime' => 'door_time',
                'duration' => $eventDuration,
                'eventStatus' => $literal('https://schema.org/EventScheduled'),
                'isAccessibleForFree' => static fn ($m) => !empty($m->is_free) ? true : null,
                'eventAttendanceMode' => static fn ($m) => !empty($m->is_virtual_event)
                    ? 'https://schema.org/OnlineEventAttendanceMode'
                    : 'https://schema.org/OfflineEventAttendanceMode',
                'url' => SchemaMapper::canonical('events.show'),
                'organizer' => SchemaMapper::orgRef(),
                'audience' => $eventAudience,
                'keywords' => $eventKeywords,
                'location' => $eventLocation,
                'offers' => $eventOffers,
            ]
        );
    }
}
