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
        $featured = $search->forSearchQuery(request('q'), 2);

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $artworks    = $artworks->forSearchQuery(request('q'), self::PER_PAGE_ARTWORKS);
        $artists     = $artists->forSearchQuery(request('q'), self::PER_PAGE);
        $exhibitions = $exhibitions->forSearchQuery(request('q'), self::PER_PAGE_EXHIBITIONS);

        $links = $this->buildSearchLinks($featured, $artworks, $artists, $exhibitions);

        return view('site.search.index', [
            'featuredResults'      => $featured->items,
            'eventsAndExhibitions' => $exhibitions,
            'artworks' => $artworks,
            'artists'  => $artists,

            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }


    protected function buildSearchLinks($all, $artworks, $artists, $exhibitions) {
        return [
            $this->buildLabel('All', $all, route('search'), true),
            $this->buildLabel('Artist', $artists, route('search'), false),
            $this->buildLabel('Artwork', $artworks, route('search'), false),
            $this->buildLabel('Exhibitions & Events', $exhibitions, route('search'), false),
        ];
    }

    protected function buildLabel($name, $collection, $href, $active) {
        return [
            'label' => ($name == 'All' ? 'All' : str_plural($name, $collection->pagination->total)) .' ('. $collection->pagination->total.')',
            'href' => $href,
            'active' => $active
        ];
    }

}
