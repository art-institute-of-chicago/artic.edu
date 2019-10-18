<?php

namespace App\Libraries\Search;
use App\Libraries\Search\Filters\Sort as SortFilters;
use App\Libraries\Search\Filters\DateRange;
use App\Libraries\Search\Filters\BooleanFilter;
use App\Libraries\Search\Filters\ColorFilter;
use App\Models\Api\Search;

class CollectionService
{
    const API_SEARCH_CACHE_TTL = 3600;

    protected $chain;

    protected $results;

    // Options for Sort Filter. Sort by these fields
    protected $sortingOptions = ['relevance', 'title', 'artist_title', 'date_start'];

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
        $this->chain = Search::query();
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
            $this->results = $builder->ttl(self::API_SEARCH_CACHE_TTL)->getPaginatedModel($this->perPage, \App\Models\Api\Artwork::SEARCH_FIELDS, null, $page);
            $this->page    = $page;
        } else {
            $this->results = $builder->ttl(self::API_SEARCH_CACHE_TTL)->getPaginatedModel($this->perPage, \App\Models\Api\Artwork::SEARCH_FIELDS);
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
        $results = $this->results();

        // Generate listing filters
        $filters = $this->buildListFilters($results->getMetadata('aggregations'));

        // Color Filter
        $filters->prepend($this->buildColorFilters());

        // Date Filter
        $filters->prepend($this->buildDateFilters());

        // Prepend sorting filters at the beginning
        if (!request('is_deaccessioned')) {
            $filters->prepend($this->buildSortFilters());
        }

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
                case 'color':
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
        $deaccessions  = (new Filters\Deaccessions())->generate();

        return array_merge($themes, $techniques, $galleries, $deaccessions);
    }

    /**
     * Go through all aggregations and process the buckets with the proper
     * filter class.
     *
     */
    protected function buildListFilters($aggregations)
    {
        $filters = collect([]);

        if ($aggregations) {
            foreach($aggregations as $name => $data)
            {
                $filterClass = __NAMESPACE__ . '\\Filters\\' . ucfirst($name);
                if (class_exists($filterClass)) {
                    $filter = new $filterClass($data->buckets, $name);
                    $filters->push($filter->generate());
                }
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

    protected function buildColorFilters()
    {
        $colorFilters = new ColorFilter();
        return $colorFilters->generate();
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
