<?php

namespace App\Http\Controllers;

use App\Models\Api\Artwork;
use App\Models\Api\Artist;
use App\Models\Api\Search as GeneralSearch;
use App\Models\Api\Exhibition;

use App\Repositories\Api\ArtworkRepository;
use App\Repositories\Api\ArtistRepository;
use App\Repositories\Api\SearchRepository;
use App\Repositories\Api\ExhibitionRepository;

use App\Http\Controllers\StaticsController;

use LakeviewImageService;

class SearchController extends FrontController
{
    const ALL_PER_PAGE = 5;
    const ALL_PER_PAGE_ARTWORKS = 8;
    const ALL_PER_PAGE_EXHIBITIONS = 4;

    const ARTWORKS_PER_PAGE = 20;

    const EXHIBITIONS_PER_PAGE = 20;

    const ARTISTS_PER_PAGE = 30;

    const AUTOCOMPLETE_PER_PAGE = 10;

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

        parent::__construct();
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
            'featuredResults'      => $general->items->where('is_boosted', true),
            'eventsAndExhibitions' => $exhibitions,
            'artworks' => $artworks,
            'artists'  => $artists,

            'allResultsView' => false,
            'searchResultsTypeLinks' => $links
        ]);
    }

    public function autocomplete()
    {
        // TODO: Integrate this search for all types and use a better approach than overwriting the results

        $query = GeneralSearch::search(request('q'))->resources(['artworks', 'exhibitions', 'artists', 'agents']);
        $collection = $query->getSearch(self::AUTOCOMPLETE_PER_PAGE);

        foreach($collection as &$item) {
            switch ($item->type) {
                case 'artwork':
                    $item->url = route('search.artworks', ['q' => $item->title]);
                    $item->section = 'Artworks';
                    break;
                case 'exhibition':
                    $item->url = route('search.exhibitionsEvents', ['q' => $item->title]);
                    $item->section = 'Exhibitions and Events';
                    break;
                case 'artist':
                    $item->url = route('search.artists', ['q' => $item->title]);
                    $item->section = 'Artists';
                    break;
            }

            $item->text = $item->title;

            if (!empty($item->image_id)) {
                $image = LakeviewImageService::getImage($item->image_id, 30);
                $image['width'] = 30;
                $image['height'] = '';
                $item->image = $image;
            }
        }

        return view('layouts/_autocomplete', [
            'term' => request('q'),
            'resultCount' => $collection->total(),
            'items' => $collection,
            'seeAllUrl' => route('search', ['q' => request('q')])
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

    public function artists()
    {
        $general = $this->searchRepository->forSearchQuery(request('q'), 2);
        $artists = $this->artistsRepository->forSearchQuery(request('q'), self::ARTISTS_PER_PAGE);

        $links = $this->buildSearchLinks($general, $general->aggregations->types->buckets, 'artists');

        return view('site.search.index', [
            'artists' => $artists,
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
            $this->buildLabel('Artist', extractAggregation($aggregations, 'agents'), route('search.artists', ['q' => request('q')]), $active == 'artists'),
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
