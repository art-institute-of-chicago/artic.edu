<?php

namespace App\Libraries\Search;
use App\Libraries\Search\Filters\Sort as SortFilters;
use App\Libraries\Search\Filters\DateRange;
use App\Libraries\Search\Filters\BooleanFilter;

class CollectionService
{
    protected $chain;

    protected $results;

    // Options for Sort Filter. Sort by these fields
    protected $sortingOptions = ['title'];

    // Options for BooleanFilter class. [ parameter => label, ... ]
    protected $booleanOptions = [
        'is_public_domain' => 'Public domain',
        'is_recent_acquisition' => 'Recent acquisition',
        'has_multimedia' => 'Has multimedia',
        'has_educational_resources' => 'Has educational resources',
        'is_on_view' => 'On view',
    ];

    // Default perPage option
    protected $perPage = 20;

    // Pagination index used as a flag to get prev/next elements
    protected $page = null;

    public function __construct()
    {
        // Use as a chain a general search
        $this->chain = \App\Models\Api\Search::query();
    }

    /**
     * Execute the query built in the chain. Save aggregations
     * to build filters.
     *
     */
    public function results($page = null)
    {
        // Memoize results to avoid double search. Consider page number (prev/next)
        if ($this->results && $page == $this->page) {
            return $this->results;
        }

        // Run the actual search query
        $builder = clone $this->chain;

        if ($page) {
            $this->results = $builder->getSearch($this->perPage, [], null, $page);
            $this->page    = $page;
        } else {
            $this->results = $builder->getSearch($this->perPage);
        }

        return $this->results;
    }

    /**
     * Generate filters for the sidebar. See Filters namespace classes.
     * There the array is generated with options to be used at the FE.
     *
     */
    public function generateFilters()
    {
        // Ensure search query has been executed
        $this->results();

        // Generate listing filters
        $filters = $this->buildListFilters($this->results->getMetadata('aggregations'));

        // Date Filter
        $filters->prepend($this->buildDateFilters());

        // Prepend sorting filters at the beginning
        $filters->prepend($this->buildSortFilters());

        // Appends boolean filters
        $filters->push($this->buildBooleanFilters());

        return $filters;
    }

    /**
     * Extract only active filters to build quick buttons
     *
     */
    public function activeFilters()
    {
        $activeFilters = collect([]);

        // Walk through filters and extract the active ones
        foreach ($this->generateFilters() as $category) {
            switch($category['type']) {
                case 'list':
                case 'dropdown':
                    foreach ($category['list'] as $item) {
                        if ($item['enabled']) {
                            $activeFilters->push([
                                'href'  => $item['href'],
                                'label' => $item['label']
                            ]);
                        }
                    }
                    break;

                case 'date':
                    if ($category['enabled']) {
                        $activeFilters->push([
                            'href'  => $category['href'],
                            'label' => $category['label']
                        ]);
                    }
                    break;
            }
        }

        // Add links to remove Hidden filters coming from Quick Facets.
        $activeFilters = $activeFilters->merge($this->getActiveHiddenFilters());

        return $activeFilters;
    }

    protected function getActiveHiddenFilters()
    {
        // These filters won't show up on the Filters Menu, but they can be present
        // as selected ones coming from Quick Filters or Gallery tag.
        $themes     = (new Filters\Themes())->generate();
        $techniques = (new Filters\Techniques())->generate();
        $galleries  = (new Filters\Galleries())->generate();

        return array_merge($themes, $techniques, $galleries);
    }

    /**
     * Go through all aggregations and process the buckets with the proper
     * filter class.
     *
     */
    protected function buildListFilters($aggregations)
    {
        $filters = collect([]);

        foreach($aggregations as $name => $data)
        {
            $filterClass = __NAMESPACE__ . '\\Filters\\' . ucfirst($name);
            if (class_exists($filterClass)) {
                $filter = new $filterClass($data->buckets, $name);
                $filters->push($filter->generate());
            }
        }

        return $filters->filter();
    }

    /**
     * Sort filters receive all possible sorting values and create
     * the proper dropdown options.
     *
     */
    protected function buildSortFilters()
    {
        $sortFilters = new SortFilters($this->sortingOptions);
        return $sortFilters->generate();
    }

    protected function buildDateFilters()
    {
        $dateFilters = new DateRange();
        return $dateFilters->generate();
    }

    protected function buildBooleanFilters()
    {
        $booleanFilters = new BooleanFilter($this->booleanOptions);
        return $booleanFilters->generate();
    }

    /**
     * Scope to save per page
     *
     */
    public function perPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Get previous & next artworks. This function basically tries to locate the element
     * within the collection, and get's prev/next elements from there. On edge cases it has
     * to perform another query to load the previous or next page (if those are available)
     *
     */
    public function getPrevNext($item, $manualResults = null)
    {
        $collection = $manualResults ?: $this->results();

        $position = $collection->values()->search(function($element, $key) use ($item) {
            return $element->id == $item->id;
        });

        // --- Section to get previous element

        if (($prevPos = $position - 1) < 0) {
            // If position is < 0 then check that previous pages exists and load the last element

            $page = $collection->currentPage();

            if ($page == 1) {
                // If it's the first element and first page then null
                $prev = null;
            } else {
                // If it's not the first page then get previous page and repeat
                $prevPage = $page - 1;
                $prev = $this->results($prevPage)->values()->last();
            }
        } else {
            // If the element exists on current collection just load it
            $prev = $collection->values()[$prevPos];
        }


        // --- Section to get next element

        if (($nextPos = $position + 1) >= $collection->count()) {
            // If position > last element then check that we have a next page and load the first element

            if ($collection->hasMorePages()) {
                // If it's not the last page then get next page and repeat
                $nextPage = $collection->currentPage() + 1;
                $next = $this->results($nextPage)->values()->first();
            } else {
                // If it's the last page then it's the last element, so null
                $next = null;
            }
        } else {
            // If the element exists on current collection just load it
            $next = $collection->values()[$nextPos];
        }

        // -- Include link parameters, this fix a bug on edge cases when you click next or prev
        // enough times to move to a different page.

        $prevParams = $nextParams = request()->input();
        if (isset($prevPage)) { $prevParams = request()->except('page') + ['page' => $prevPage]; }
        if (isset($nextPage)) { $nextParams = request()->except('page') + ['page' => $nextPage]; }

        return (object) [
            'prev' => $prev,
            'prevParams' => $prevParams,
            'next' => $next,
            'nextParams' => $nextParams
        ];
    }

    /**
     * Bypass missed methods directly to the chain.
     * Chain is usually a Query Builder type (eloquent or AIC API query builder)
     *
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method($parameters);
        }

        $this->chain->{$method}(...$parameters);

        return $this;
    }

}
