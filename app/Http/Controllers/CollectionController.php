<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Libraries\Search\CollectionService;

class CollectionController extends BaseScopedController
{
    const PER_PAGE = 50;

    protected $apiRepository;
    protected $searchRepository;

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

        if (request('is_deaccessioned')) {
            $collectionService->resources(['deaccessions']);
        }

        return $collectionService;
    }

    public function index()
    {
        // WEB-1287: Redirect some common boolean filters
        if (in_array(strtolower(request('q')), [
            'cc0',
            'public domain',
            'creative commons',
        ])) {
            return redirect(route('collection', ['is_public_domain' => 1]));
        }

        $collection = $this->collection()->perPage(static::PER_PAGE)->results();

        // If first artwork accession number matches search query, redirect to artwork page
        if ($collection->count()) {
            $artwork = $collection->first();
            if ($artwork->main_reference_number == request('q')) {
                return redirect(route('artworks.show', $artwork));
            }
        }

        $page = Page::forType('Art and Ideas')->with('apiElements')->first();
        $filters       = $this->collection()->generateFilters();
        $activeFilters = $this->collection()->activeFilters();

        if ($activeFilters->count()) {
            $this->seo->setTitle(implode(', ', $activeFilters->pluck('label')->all()));
        }
        else {
            $this->seo->setTitle('Discover Art & Artists');
        }

        if ($collection->count()) {
            // Use first image of results as the social image
            $artwork = $collection->first();
            $this->seo->setImage($artwork->imageFront('hero'));
        }
        else {
            // Otherwise, fall back to American Gothic as social image
            $this->seo->image = 'https://' .rtrim(config('app.url'), '/') . '/iiif/2/d02e0079-8e82-733e-683c-cb83a387ee5e/full/1200,/0/default.jpg';
            $this->seo->width = 1200;
            $this->seo->height = 1459;
        }

        $description = "Discover art by Van Gogh, Picasso, Warhol & more in the Art Institute's collection spanning 5,000 years of creativity.";

        if (request('q')) {
            $description = 'You searched for: ' .request('q') .'. ' .$description;
        }
        $this->seo->setDescription($description);
        $this->seo->nofollow = $this->setNofollowMeta();

        // If it's a call to Load More, just show the items and do not generate a full page
        if (\Route::current()->getName() == 'collection.more') {
            $view['html'] = view('site.collection._items', [
                'artworks' => $collection
            ])->render();

            if ($collection->hasMorePages())
                $view['page'] = request('page');

            return $view;
        }

        $featuredItems = $page->getRelatedWithApiModels(
            'featured_items', [], [
                'articles' => false,
                'interactiveFeatures.experiences' => false
        ]);

        $page = Page::forType('Art and Ideas')->with('apiElements')->first();
        $filters       = $this->collection()->generateFilters();
        $activeFilters = $this->collection()->activeFilters();

        if ($featuredItems->count()) {
            $featuredItemsHero = $featuredItems->shift();
        }

        return view('site.collection.index', [
          'primaryNavCurrent' => 'collection',
          'page'              => $page,
          'artworks'          => $collection,
          'filterCategories'  => $filters,
          'activeFilters'     => $activeFilters,
          'hasAnyFilter'      => $this->hasAnyScope(),
          'featuredItemsHero' => $featuredItemsHero ?? null,
          'featuredItems'     => $featuredItems ?? null,
        ]);
    }

    // Endpoint to search within filters.
    // To perform this we hit the same collection endpoint (with no results)
    // and then build filters from the returned aggregations
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

        return response()->json($results, 200);
    }

    /**
     * If you have more than 1 filter, or more than 1 option selected
     * on the same filter add a nofollow flag. (only 1 possible option selected)
     *
     */
    protected function setNofollowMeta()
    {
        $count = count(request()->input());

        if ($count > 1) {
            return true;
        } else {
            if ($count == 1) {
                // If there's only one selected filter, check if it has more than one active element
                $input = request()->input();

                if (count(explode(';', array_shift($input))) > 1) {
                    return true;
                }
            }
        }
    }

}
