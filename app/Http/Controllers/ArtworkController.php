<?php

namespace App\Http\Controllers;
use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;

class ArtworkController extends FrontController
{
    protected $artworkRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->artworkRepository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item = Artwork::query()->include(['artist_pivots', 'place_pivots'])->findOrFail((Integer) $idSlug);
        if (empty($item)) {
            abort(404);
        }

        // TODO: refactor these out
        aic_addToRecentlyViewedArtworks($item);
        $recentlyViewed = aic_getRecentlyViewedArtworks();

        if (sizeof($recentlyViewed) > 2) {
            $recentlyViewed = null;
        }

        // Build Explore further module
        $exploreFurtherCollection = $this->artworkRepository->exploreFurtherCollection($item, request()->only('exFurther-classification', 'exFurther-style', 'exFurther-artist'));
        $exploreFurtherTags = $this->artworkRepository->exploreFurtherTags($item);

        return view('site.artworkDetail', [
          'item' => $item,
          'contrastHeader'   => $item->present()->contrastHeader,
          'borderlessHeader' => $item->present()->borderlessHeader,
          'exploreFurther'   => $exploreFurtherCollection,
          'exploreFurtherTags' => $exploreFurtherTags,
          'recentlyViewedArtworks' => $recentlyViewed
        ]);
    }

}
