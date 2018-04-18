<?php

namespace App\Libraries\Search;
use App\Libraries\Search\Filters\Sort as SortFilters;

class CollectionService
{
    protected $chain;

    protected $results;
    protected $aggregationsData;
    protected $sortingOptions = ['title', 'name'];

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

        // Prepend sorting filters at the beginning
        $filters->prepend($this->buildSortFilters());

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
            foreach ($category['list'] as $item) {
                if ($item['enabled']) {
                    $activeFilters->push([
                        'href'  => $item['href'],
                        'label' => $item['label']
                    ]);
                }
            }
        }

        return $activeFilters;
    }

    /**
     * Go through all aggregations and process the buckets with the proper
     * filter class.
     * Filter class could be a list, date range, checkbox.
     *
     */
    protected function buildListFilters($aggregations)
    {
        $filters = collect([]);

        foreach($aggregations as $name => $data)
        {
            $filterClass = __NAMESPACE__ . '\\Filters\\' . ucfirst($name);
            $filter = new $filterClass($data->buckets);

            $filters->push($filter->generate());
        }

        return $filters->filter();
    }

    /**
     * Go through all aggregations and process the buckets with the proper
     * filter class.
     * Filter class could be a list, date range, checkbox.
     *
     */
    protected function buildSortFilters()
    {
        $sortFilters = new SortFilters($this->sortingOptions);
        $allFilters  = $sortFilters->generate();
        return $allFilters;
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
