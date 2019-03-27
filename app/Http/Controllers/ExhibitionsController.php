<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\EventRepository;
use Carbon\Carbon;

class ExhibitionsController extends FrontController
{
    protected $apiRepository;
    protected $eventRepository;

    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(ExhibitionRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->apiRepository = $repository;
        $this->eventRepository = $eventRepository;

        parent::__construct();
    }

    public function index($upcoming = false)
    {
        // NOTE: Naming conventions for the CMS browsers might be counterintuitive (for backwards compatibility).
        //
        // exhibitionsExhibitions: Featured exhibitions
        // exhibitionsCurrent: Current exhibitions listing
        // exhibitionsUpcoming: Featured upcoming exhibitions
        // exhibitionsUpcomingListing: Upcoming exhibitions listing.

        $this->seo->setTitle('Exhibitions');
        $this->seo->setDescription("Now on view—explore the Art Institute's current and upcoming exhibits to plan your visit.");

        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        if ($upcoming) {
            $collection = $page->apiModels('exhibitionsUpcomingListing', 'Exhibition');
            // $collection = $collection->filter( function( $value, $key) {
            //     return Carbon::now() <= $value->aic_date_start;
            // });
        } else {
            $collection = $page->apiModels('exhibitionsCurrent', 'Exhibition');
        }

        $events = $this->eventRepository->getEventsFiltered(Carbon::now(), null, null, null, null, null, 3, 1);
        $eventsByDay = $this->eventRepository->groupByDate($events);

        $featured = $upcoming ? $page->apiModels('exhibitionsUpcoming', 'Exhibition') : $page->apiModels('exhibitionsExhibitions', 'Exhibition');

        return view('site.exhibitions', [
            'page' => $page,
            'collection' => $collection,
            'eventsByDay' => $eventsByDay,
            'events' => $events,
            'upcoming' => $upcoming,
            'featured' => $featured,
            'primaryNavCurrent' => 'exhibitions_and_events',
        ]);
    }

    public function upcoming()
    {
        return $this->index(true);
    }

    protected function show($id, $slug = null)
    {
        $item = $this->apiRepository->getById((Integer) $id, ['apiElements']);

        // If the exhibition has not started or not ended, check if its augmented model is published before showing
        if ((Carbon::now()->lt($item->dateStart) || Carbon::now()->lt($item->dateEnd)) && !$item->published)
        {
            abort(404);
        }

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('exhibitions.show', ['id' => $item->id, 'slug' => $item->titleSlug ], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->seo_description);
        $this->seo->setImage($item->imageFront('hero'));

        $collection = $this->eventRepository->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE);
        $relatedEventsByDay = $this->eventRepository->groupByDate($collection);

        return view('site.exhibitionDetail', [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
            'relatedEventsByDay' => $relatedEventsByDay,
            'canonicalUrl' => route('exhibitions.show', ['id' => $item->id, 'slug' => $item->titleSlug ]),
        ]);
    }

    public function loadMoreRelatedEvents($idSlug)
    {
        $item = $this->apiRepository->getById((Integer) $idSlug);
        $collection = $this->eventRepository->getRelatedEvents($item, self::RELATED_EVENTS_PER_PAGE, request('page'));
        $relatedEventsByDay = $this->eventRepository->groupByDate($collection);

        $view['html'] = view('statics.exhibitions_load_more', [
            'items' => $relatedEventsByDay,
        ])->render();

        if ($collection->hasMorePages()) {
            $view['page'] = request('page');
        }

        return $view;
    }

}
