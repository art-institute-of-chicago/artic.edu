<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Api\ArtworkRepository;
use App\Models\Api\Artwork;
use App\Models\Page;

use LakeviewImageService;

class CollectionController extends FrontController
{
    protected $apiRepository;

    public function __construct(ArtworkRepository $repository)
    {
        $this->apiRepository = $repository;
        parent::__construct();
    }

    public function index()
    {
        $page = Page::forType('Art and Ideas')->with('apiElements')->first();

        // If we don't have a query let's load the boosted artworks
        if (request('q')) {
            $collection = \App\Models\Api\Search::search(request('q'))->resources(['artworks'])->getSearch();
        } else {
            $collection = \App\Models\Api\Artwork::query()->forceEndpoint('boosted')->get();
        }

        // If it's ajax, just load more elements.
        if (request()->ajax() && request()->has('page')) {
            return [
                'page' => request('page'),
                'html' => view('site.collection.items', [
                    'artworks' => $collection
                ])->render()
            ];
        }

        return view('site.collection.index', [
          'primaryNavCurrent' => 'collection',
          'title' => 'The Collection',
          'intro' => $page->art_intro,
          'quickSearchLinks' => [],
          'filters' => [],
          'filterCategories' => [],
          'activeFilters' => array(
            array(
              'href' => '#',
              'label' => "Arms",
            ),
            array(
              'href' => '#',
              'label' => "Legs",
            ),
          ),
          'artworks' => $collection,
          'recentlyViewedArtworks' => [],
          'interestedThemes' => array(
            array(
              'href' => '#',
              'label' => "Picasso",
            ),
            array(
              'href' => '#',
              'label' => "Modern Art",
            ),
            array(
              'href' => '#',
              'label' => "European Art",
            ),
          ),
          'featuredArticlesHero' => [],
          'featuredArticles' => [],
        ]);

    }

    public function clearRecentlyViewed()
    {
        aic_clearRecentlyViewedArtworks();
        return redirect()->back();
    }

    public function autocomplete()
    {
        // Collection autocomplete is just a text one. Images and rich suggestions are used on General ones.

        $results = \App\Models\Api\Search::search(request('q'))->forceEndpoint('autocomplete')->getRaw();
        $items   = [];

        foreach($results as $i) {
            array_push($items, array(
                'href' => route('collection', ['q' => request('q')]),
                'label' => $i,
            ));
        }

        return view('components/molecules/_m-search-bar__autocomplete', [
            'items' => $items
        ]);
    }

}
