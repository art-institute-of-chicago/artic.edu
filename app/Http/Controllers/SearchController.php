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

    protected $artworksRepository;
    protected $artistsRepository;
    protected $searchRepository;
    protected $exhibitionsRepository;

    public function __construct(
        ArtworkRepository $artworks,
        ArtistRepository $artists,
        SearchRepository $search,
        ExhibitionRepository $exhibitions
    ) {
        $this->artworksRepository = $artworks;
        $this->artistsRepository = $artists;
        $this->searchRepository = $search;
        $this->exhibitionsRepository = $exhibitions;
    }


    public function index()
    {
        // General search to get featured elements and general metadata.
        $featured = $this->searchRepository->forSearchQuery(request('q'), 2);

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $artworks    = $this->artworksRepository->forSearchQuery(request('q'), self::PER_PAGE_ARTWORKS);
        $artists     = $this->artistsRepository->forSearchQuery(request('q'), self::PER_PAGE);
        $exhibitions = $this->exhibitionsRepository->forSearchQuery(request('q'), self::PER_PAGE_EXHIBITIONS);

        $links = $this->buildSearchLinks($featured, $artworks, $artists, $exhibitions, 'all');

        return view('site.search.index', [
            'featuredResults'      => $featured->items,
            'eventsAndExhibitions' => $exhibitions,
            'artworks' => $artworks,
            'artists'  => $artists,

            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }

    protected function buildSearchLinks($all, $artworks, $artists, $exhibitions, $active = 'all') {
        return [
            $this->buildLabel('All', $all, route('search'), $active == 'all'),
            $this->buildLabel('Artist', $artists, route('search'), $active == 'artists'),
            $this->buildLabel('Artwork', $artworks, route('search'), $active == 'artworks'),
            $this->buildLabel('Exhibitions & Events', $exhibitions, route('search'), $active == 'exhibitions'),
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
