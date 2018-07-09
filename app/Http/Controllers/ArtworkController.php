<?php

namespace App\Http\Controllers;
use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Libraries\RecentlyViewedService;
use App\Libraries\Search\CollectionService;
use App\Libraries\ExploreFurther\ArtworkService as ExploreFurther;

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

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->fullTitle);

        // Get previous and next artwork using BaseScopedController filters
        // Basically it performs a search again and locates both prev/next works
        $prevNext = $this->collection()->getPrevNext($item);

        // Build Explore further module
        $exploreFurther = new ExploreFurther($item);

        return view('site.artworkDetail', [
          'item' => $item,
          'contrastHeader'    => $item->present()->contrastHeader,
          'borderlessHeader'  => $item->present()->borderlessHeader,
          'prevNextObject'    => $prevNext,
          'primaryNavCurrent' => 'collection',
          'exploreFurtherTags'    => $exploreFurther->tags(),
          'exploreFurther'        => $exploreFurther->collection(request()->all()),
          'exploreFurtherAllTags' => $exploreFurther->allTags(request()->all()),
          'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
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
        $recentlyViewed  = $service->getArtworks();
        $suggestedThemes = $service->getThemes();

        $view['html'] = view('site.shared._recentlyViewed', [
            'artworks' => $recentlyViewed,
            'interestedThemes' => $suggestedThemes
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
