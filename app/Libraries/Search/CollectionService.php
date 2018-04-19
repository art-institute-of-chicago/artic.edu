<?php

namespace App\Libraries\Search;
use App\Libraries\Search\Filters\Sort as SortFilters;
use App\Libraries\Search\Filters\DateRange;
use App\Libraries\Search\Filters\BooleanFilter;

class CollectionService
{
    protected $chain;

    protected $results;
    protected $aggregationsData;

    // Options for Sort Filter. Sort by these fields
    protected $sortingOptions = ['title'];

    // Options for BooleanFilter class. [ parameter => label, ... ]
    protected $booleanOptions = [
        'is_public_domain' => 'Public Domain'
    ];

    protected $perPage = 20;

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
    public function results()
    {
        // Memoize results to avoid double search
        if ($this->results)
            return $this->results;

        // Run the actual search query
        $builder = clone $this->chain;
        $this->results = $builder->getSearch($this->perPage);

        // Save aggregations data
        $this->aggregationsData = $builder->aggregationsData;

        return $this->results;
    }

    /**
     * Generate filters for the sidebar. See Filters namespace classes.
     * There the array is generated with options to be used at the FE.
     *
     */
    public function generateFilters()
    {
        // Ensure the a search query has been executed
        $this->results();

        // Generate listing filters
        $filters = $this->buildListFilters($this->aggregationsData);

        //TODO: Integrate this hardcoded filter to be generated with proper date ranges
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

        return $activeFilters;
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
                $filter = new $filterClass($data->buckets);
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
     * Bypass missed methods directly to the chain.
     * Chain is usually a Query Builder type (eloquent or AIC API query builder)
     *
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method($parameters);
        }

        return $this->chain->{$method}(...$parameters);
    }

}
