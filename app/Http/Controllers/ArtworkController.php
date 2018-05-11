<?php

namespace App\Http\Controllers;
use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Libraries\RecentlyViewedService;
use App\Libraries\Search\CollectionService;

class ArtworkController extends BaseScopedController
{
    const PER_PAGE = 20;

    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item = Artwork::query()
            ->include(['artist_pivots', 'place_pivots', 'dates', 'catalogue_pivots'])
            ->findOrFail((Integer) $idSlug);

        if (empty($item)) {
            abort(404);
        }

        // Get previous and next artwork using BaseScopedController filters
        // Basically it performs a search again and locates both prev/next works
        $prevNext = $this->collection()->getPrevNext($item);

        // Build Explore further module
        $exploreFurtherTags = $this->artworkRepository->exploreFurtherTags($item);
        if (request()->has('exFurther-all')) {
            $exploreFurtherAllTags = $this->artworkRepository->exploreFurtherAllTags();
        } else {
            $exploreFurtherCollection = $this->artworkRepository->exploreFurtherCollection($item, request()->only('exFurther-classification', 'exFurther-style', 'exFurther-artist'));
        }


        return view('site.artworkDetail', [
          'item' => $item,
          'contrastHeader'     => $item->present()->contrastHeader,
          'borderlessHeader'   => $item->present()->borderlessHeader,
          'exploreFurther'     => $exploreFurtherCollection ?? null,
          'exploreFurtherTags' => $exploreFurtherTags,
          'exploreFurtherAllTags' => $exploreFurtherAllTags ?? null,
          'prevNextObject'        => $prevNext,
          'primaryNavCurrent'  => 'collection',
        ]);
    }

    /**
     * Implementation for BaseScopedController.
     * This is the beginning for the chain of scoped results
     * The remaining scopes are applied following the $scopes
     * array defined at the controller
     *
     */
    protected function beginOfAssociationChain()
    {
        // Define base entity
        $collectionService = new CollectionService;

        // Implement default filters and scopes
        $collectionService->resources(['artworks'])
            ->allAggregations()
            ->forceEndpoint('search');

        return $collectionService;
    }

    protected function getPrevNext()
    {
        $collection = $this->collection()->perPage(static::PER_PAGE)->results();
    }

    public function recentlyViewed(RecentlyViewedService $service)
    {
        $recentlyViewed = $service->getArtworks();

        // TODO: Integrate themes
        $view['html'] = view('site.shared._recentlyViewed', [
            'artworks' => $recentlyViewed,
            'interestedThemes'   => [
                [
                  'href' => '#',
                  'label' => "Picasso",
                ],
                [
                  'href' => '#',
                  'label' => "Monet",
                ]
            ]
        ])->render();

        return $view;
    }

    public function clearRecentlyViewed(RecentlyViewedService $service)
    {
        $service->clear();

        return redirect()->back();
    }

    public function addRecentlyViewed($idSlug, RecentlyViewedService $service)
    {
        $item = Artwork::query()->findOrFail((Integer) $idSlug);

        if (empty($item)) {
            abort(404);
        } else {
            // Add artwork to the Recently Viewed collection
            $service->addArtwork($item);
        }
    }

}
