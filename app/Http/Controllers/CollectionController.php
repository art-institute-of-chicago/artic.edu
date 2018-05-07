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
        'place_ids'    => 'byPlaces',
        'sort_by'      => 'sortBy',
        'date-start'   => 'dateMin',
        'date-end'     => 'dateMax',
        'is_on_view'   => 'onView',
        'classification_ids' => 'byClassifications',
        'department_ids'     => 'byDepartments',
        'is_public_domain'   => 'publicDomain',

        // Hidden from filters but present in Quick facets
        'theme_ids'     => 'byThemes',
        'gallery_ids'   => 'byGalleryIds',
        'technique_ids' => 'byTechniques',
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
            ->allAggregations(request()->route('categoryName'), request()->get('categoryQuery'))
            ->forceEndpoint('search');

        return $collectionService;
    }

    public function index()
    {
        $collection = $this->collection()->perPage(static::PER_PAGE)->results();

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
          'page'              => $page,
          'artworks'         => $collection,
          'filterCategories' => $filters,
          'activeFilters'    => $activeFilters,
          'featuredArticlesHero'   => [],
          'featuredArticles'       => []
        ]);
    }

    // Endpoint to search within filters.
    // To perform this we hit the same collection endpoint (with no results)
    // And build filters from the returned aggregations
    public function categorySearch($category)
    {
        // Search through the facets including current parameters. Get only aggregations.
        $collection = $this->collection()->results(0);
        $filters    = $this->collection()->generateFilters();

        // Get the correct aggregation
        $list = $filters->where('aggregation', $category)->first();

        // Print just those links
        $view['html'] = view('site.collection._filtersItems', [
            'links' => ($list && !empty($list['list']) ? $list['list'] : [])
        ])->render();

        return $view;
    }

    public function autocomplete()
    {
        // Collection autocomplete is just text.
        // So we use a raw query directly.
        $results = \App\Models\Api\Search::search(request('q'))
            ->forceEndpoint('autocomplete')
            ->resources(['artworks', 'agents'])
            ->getRaw();

        $items = collect([]);

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
