<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Libraries\Search\CollectionService;

use LakeviewImageService;

class CollectionController extends BaseScopedController
{
    const PER_PAGE = 20;

    protected $apiRepository;
    protected $searchRepository;

    protected $scopes = [
        'q'            => 'search',
        'artist_ids'   => 'byArtists',
        'style_ids'    => 'byStyles',
        'subject_ids'  => 'bySubjects',
        'material_ids' => 'byMaterials',
        'sort_by'      => 'sortBy',
        'date-start'   => 'dateMin',
        'date-end'     => 'dateMax',
        'classification_ids' => 'byClassifications',
    ];

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

    public function index()
    {
        // If we don't have a query let's load the boosted artworks
        // $collection = \App\Models\Api\Artwork::query()->forceEndpoint('boosted')->paginate(self::PER_PAGE);

        $collection = $this->collection()->results(static::PER_PAGE);

        // If it's a call to Load More, just show the items and do not generate a full page
        if (\Route::current()->getName() == 'collection.more') {
            $view['html'] = view('site.collection._items', [
                'artworks' => $collection
            ])->render();

            if ($collection->hasMorePages())
                $view['page'] = request('page');

            return $view;
        }

        $page = Page::forType('Art and Ideas')->with('apiElements')->first();
        $filters       = $this->collection()->generateFilters();
        $activeFilters = $this->collection()->activeFilters();

        return view('site.collection.index', [
          'primaryNavCurrent' => 'collection',
          'intro'            => $page->art_intro,
          'artworks'         => $collection,
          'filterCategories' => $filters,
          'activeFilters'    => $activeFilters,
          'quickSearchLinks' => [],
          'recentlyViewedArtworks' => [],
          'featuredArticlesHero'   => [],
          'featuredArticles'       => [],
          'interestedThemes' => array(
            array(
              'href' => '#',
              'label' => "Picasso",
            )
          ),
        ]);
    }

    public function clearRecentlyViewed()
    {
        aic_clearRecentlyViewedArtworks();
        return redirect()->back();
    }

    public function autocomplete()
    {
        // Collection autocomplete is just text.
        // So we use a raw query directly.
        $results = \App\Models\Api\Search::search(request('q'))->forceEndpoint('autocomplete')->getRaw();
        $items   = collect([]);

        foreach($results as $label) {
            $items->push([
                'href'  => route('collection', request()->except('q') + ['q' => $label]),
                'label' => $label,
            ]);
        }

        return view('components/molecules/_m-search-bar__autocomplete', [
            'items' => $items
        ]);
    }

}
