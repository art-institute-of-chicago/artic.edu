<?php

namespace App\Http\Controllers;

use App\Models\Api\Artwork;
use App\Models\Api\Artist;
use App\Models\Api\Exhibition;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\ArtistRepository;
use App\Repositories\Api\SearchRepository;
use App\Repositories\Api\ExhibitionRepository;

class SearchController extends Controller
{
    const PER_PAGE = 5;
    const PER_PAGE_ARTWORKS = 8;
    const PER_PAGE_EXHIBITIONS = 4;

    public function index(
        ArtworkRepository $artworks,
        ArtistRepository $artists,
        SearchRepository $search,
        ExhibitionRepository $exhibitions
    ) {
        // General search to get featured elements and general metadata.
        $collection = $search->forSearchQuery('picasso');

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $artworks    = $artworks->forSearchQuery(request('q'), self::PER_PAGE_ARTWORKS);
        $artists     = $artists->forSearchQuery(request('q'), self::PER_PAGE);
        $exhibitions = $exhibitions->forSearchQuery(request('q'), self::PER_PAGE_EXHIBITIONS);

        return view('site.search.index', [
            'collection'  => $collection,
            'artworks'    => $artworks,
            'artists'     => $artists,
            'eventsAndExhibitions' => $exhibitions,

            'allResultsView' => false
        ]);
    }

}
