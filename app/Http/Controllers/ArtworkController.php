<?php

namespace App\Http\Controllers;
use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Libraries\RecentlyViewedService;

class ArtworkController extends FrontController
{
    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    public function show($idSlug, RecentlyViewedService $recentlyViewed)
    {
        $item = Artwork::query()
            ->include(['artist_pivots', 'place_pivots', 'dates', 'catalogue_pivots'])
            ->findOrFail((Integer) $idSlug);

        if (empty($item)) {
            abort(404);
        } else {
            // Add artwork to the Recently Viewed collection
            $recentlyViewed->addArtwork($item);
        }

        // Build Explore further module
        $exploreFurtherCollection = $this->artworkRepository->exploreFurtherCollection($item, request()->only('exFurther-classification', 'exFurther-style', 'exFurther-artist'));
        $exploreFurtherTags = $this->artworkRepository->exploreFurtherTags($item);

        return view('site.artworkDetail', [
          'item' => $item,
          'contrastHeader'     => $item->present()->contrastHeader,
          'borderlessHeader'   => $item->present()->borderlessHeader,
          'exploreFurther'     => $exploreFurtherCollection,
          'exploreFurtherTags' => $exploreFurtherTags,
        ]);
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
