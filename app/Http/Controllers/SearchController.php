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
    const ALL_PER_PAGE = 5;
    const ALL_PER_PAGE_ARTWORKS = 8;
    const ALL_PER_PAGE_EXHIBITIONS = 4;

    const ARTWORKS_PER_PAGE = 20;

    const EXHIBITIONS_PER_PAGE = 20;

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
        $general = $this->searchRepository->forSearchQuery(request('q'), 2);

        // Specific elements search. We run separate queries because we want to ensure elements
        // in all sections. A general search sorting might cause empty categories.
        $artworks    = $this->artworksRepository->forSearchQuery(request('q'), self::ALL_PER_PAGE_ARTWORKS);
        $artists     = $this->artistsRepository->forSearchQuery(request('q'), self::ALL_PER_PAGE);
        $exhibitions = $this->exhibitionsRepository->forSearchQuery(request('q'), self::ALL_PER_PAGE_EXHIBITIONS);

        $links = $this->buildSearchLinks($general, $general->aggregations->types->buckets, 'all');

        return view('site.search.index', [
            'featuredResults'      => $general->items,
            'eventsAndExhibitions' => $exhibitions,
            'artworks' => $artworks,
            'artists'  => $artists,

            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }

    public function artworks()
    {
        // TODO: THIS IS A FULL COLLECTION SEARCH
        // Integrate it after collections search are done.

        $general  = $this->searchRepository->forSearchQuery(request('q'), 2);
        $artworks = $this->artworksRepository->forSearchQuery(request('q'), self::ARTWORKS_PER_PAGE);

        $links = $this->buildSearchLinks($general, $general->aggregations->types->buckets, 'artworks');

        return view('site.search.index', [
            'artworks' => $artworks,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
            'filterCategories' => [],
            'activeFilters' => array(
              array(
                'href' => '#',
                'label' => "Arms",
              ),
              array(
                'href' => '#',
                'label' => "Legs",
              )
            ),
        ]);
    }

    public function exhibitionsEvents()
    {
        $general     = $this->searchRepository->forSearchQuery(request('q'), 2);
        $exhibitions = $this->exhibitionsRepository->forSearchQuery(request('q'), self::EXHIBITIONS_PER_PAGE);

        $links = $this->buildSearchLinks($general, $general->aggregations->types->buckets, 'exhibitions');

        return view('site.search.index', [
            'eventsAndExhibitions' => $exhibitions,
            'allResultsView' => true,
            'searchResultsTypeLinks' => $links,
            'filterCategories' => [],
            'activeFilters' => array(
              array(
                'href' => '#',
                'label' => "Arms",
              ),
              array(
                'href' => '#',
                'label' => "Legs",
              )
            ),
        ]);
    }

    protected function buildSearchLinks($all, $aggregations, $active = 'all')
    {
        return [
            $this->buildLabel('All', $all->pagination->total, route('search'), $active == 'all'),
            $this->buildLabel('Artist', extractAggregation($aggregations, 'agents'), route('search'), $active == 'artists'),
            $this->buildLabel('Artwork', extractAggregation($aggregations, 'artworks'), route('search.artworks', ['q' => request('q')]), $active == 'artworks'),
            $this->buildLabel('Exhibitions & Events', extractAggregation($aggregations, 'exhibitions'), route('search.exhibitionsEvents', ['q' => request('q')]), $active == 'exhibitions'),
        ];
    }

    protected function buildLabel($name, $total, $href, $active) {
        return [
            'label' => ($name == 'All' ? 'All' : str_plural($name, $total)) .' ('. $total.')',
            'href' => $href,
            'active' => $active
        ];
    }

}
