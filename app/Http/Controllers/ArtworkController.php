<?php

namespace App\Http\Controllers;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Helpers\GtmHelpers;
use App\Libraries\RecentlyViewedService;
use App\Libraries\Search\CollectionService;
use App\Libraries\ExploreFurther\ArtworkService as ExploreFurther;

class ArtworkController extends BaseScopedController
{
    public const PER_PAGE = 20;

    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        try {
            $item = Artwork::query()
                ->include(['artist_pivots', 'place_pivots', 'dates'])
                ->findOrFail((int) $id);
        } catch (\Throwable $e) {
            $item = Artwork::query()->forceEndpoint('deaccession')
                ->include(['artist_pivots', 'place_pivots', 'dates'])
                ->findOrFail((int) $id);
        }

        $canonicalPath = route('artworks.show', ['id' => $item->id, 'slug' => $item->titleSlug]);

        if ($canonicalRedirect = $this->getCanonicalRedirect($canonicalPath)) {
            return $canonicalRedirect;
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: $item->fullArtist);
        $this->seo->setImage($item->imageFront('hero'), 843);
        $this->seo->usesImgix = false;

        if ($item->mainArtist && $item->mainArtist->isNotEmpty()) {
            $this->seo->citationAuthor[] = $item->mainArtist->first()->title;
        }

        if ($item->artists && $item->artists->isNotEmpty()) {
            $item->artists->each(function ($artist) {
                $this->seo->citationAuthor[] = $artist->title;
            });
        }

        $featuredRelated = collect($item->getFeaturedRelated())->pluck('item');

        $featuredRelatedIds = $featuredRelated->pluck('id');

        // Get auto related items & evaluate if they are featured

        $autoRelated = collect($item->related($item->id))->unique('id')->filter();

        // Remove featured related items from auto related items
        if ($featuredRelatedIds->isNotEmpty()) {
            $autoRelated = $autoRelated->reject(function ($relatedItem) use ($featuredRelatedIds) {
                return ($relatedItem !== null && ($featuredRelatedIds->contains($relatedItem->id) || $featuredRelatedIds->contains($relatedItem->datahub_id)));
            });
        }

        // Start building data for output to view
        $viewData = [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'item' => $item,
            'model3d' => $item->model3d,
            'contrastHeader' => $item->present()->contrastHeader,
            'borderlessHeader' => $item->present()->borderlessHeader,
            'primaryNavCurrent' => 'collection',
            'canonicalUrl' => $canonicalPath,
            'pageMetaData' => $this->getPageMetaData($item),
        ];

        // Build Explore further module
        if (!$item->is_deaccessioned) {
            $exploreFurther = new ExploreFurther($item);

            $viewData = array_merge($viewData, [
                'exploreFurtherTags' => $exploreFurther->tags(),
                'exploreFurther' => $exploreFurther->collection(request()->all()),
                'exploreFurtherAllTags' => $exploreFurther->allTags(request()->all()),
                'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            ]);
        }

        return view('site.artworkDetail', $viewData);
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
        $collectionService = new CollectionService();

        // Implement default filters and scopes
        $collectionService->resources(['artworks'])
            ->allAggregations()
            ->forceEndpoint('search');

        return $collectionService;
    }

    public function recentlyViewed(RecentlyViewedService $service)
    {
        $recentlyViewed = $service->getArtworks();
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

    public function addRecentlyViewed(RecentlyViewedService $service, $idSlug, $slug = null)
    {
        $item = Artwork::query()->findOrFail((int) $idSlug);

        if (empty($item)) {
            abort(404);
        } else {
            // Add artwork to the Recently Viewed collection
            $service->addArtwork($item);
        }

        return response()->json();
    }

    public function exploreFurther($id)
    {
        try {
            $item = Artwork::query()
                ->include(['artist_pivots'])
                ->findOrFail((int) $id);
        } catch (\Throwable $e) {
            $item = Artwork::query()->forceEndpoint('deaccession')
                ->include(['artist_pivots'])
                ->findOrFail((int) $id);
        }

        $exploreFurther = new ExploreFurther($item);

        if (request()->has('ef-all_ids')) {
            $view['html'] = view('site.shared._exploreFurtherTags', [
                'tags' => $exploreFurther->allTags(request()->all()),
            ])->render();
        } else {
            $view['html'] = view('site.shared._exploreFurther', [
                'artworks' => $exploreFurther->collection(request()->all()),
            ])->render();
        }

        return $view;
    }

    protected function setPageMetaData($item)
    {
        return GtmHelpers::getMetaDataForArtwork($item);
    }
}
