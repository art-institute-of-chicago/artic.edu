<?php

namespace App\Libraries\ExploreFurther;
use App\Models\Api\Search;

/**
 *
 * Service used to retrieve explore further elements.
 * Tags, artworks, view more link and 'All tags' list
 *
 */

class BaseService
{
    const MAX_TAGS = 3;
    const PER_PAGE_EXPLORE_FURTHER = 13;

    // Array with valid filters for the Explore Further section.
    const VALID_FILTERS = [
        'ef-classification_ids',
        'ef-artist_ids',
        'ef-style_ids'
    ];

    protected $resource;
    protected $aggregations;

    public function __construct($item, $aggregations = null)
    {
        $this->resource = $item;
        $this->aggregations = $aggregations;
    }

    public function aggregations()
    {
        // Overload this function if you need a different data source
        // Than the aggregations passed at the constructor
        return $this->aggregations;
    }

    public function allTags($parameters = [])
    {
        $parameters = collect($parameters);

        if ($parameters->has('ef-all_ids')) {
            return $this->getAllTags();
        }
    }

    public function getAllTags()
    {
        // Use same query as search to hit the cache instead of creating a new one.
        $buckets = $this->aggregations()->classifications->buckets;

        return collect($buckets)->mapWithKeys(function ($item) {
            return [route('collection', ['classification_ids' => $item->key]) => ucfirst($item->key)];
        });
    }

    public function tags()
    {
        $tags = collect([]);

        // Build Classification Tags
        if ($this->resource->id) {
            foreach($this->aggregations()->classifications->buckets as $index => $item) {
                if ($index == self::MAX_TAGS) {
                    break;
                }

                $tags = $tags->merge(
                    [$item->key => ucfirst($item->key)]
                );
            };
        }

        return [
            'classification' => $tags,
        ];
    }

    public function collection($parameters = [])
    {
        $parameters = collect($parameters);

        $query = Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search');

        $active = $parameters->filter(function($value, $key) {
            return str_contains($key, 'ef-');
        })->isNotEmpty();

        if ($active) {
            $query->byClassifications($parameters->get('ef-classification_ids'))
                  ->byArtists($parameters->get('ef-artist_ids'))
                  ->byStyles($parameters->get('ef-style_ids'));
        } else {
            // When no filter selected, use the first filter available.
            $category = key($this->tags());

            // ...but abort if the first filter is `null` or "all"
            if (!$category || $category === 'all') {
                return collect([]);
            }

            // Parse the ID coming from the tags
            $id = $this->tags()[$category]->keys()->first();

            // Call the appropiate scope
            switch ($category) {
                case 'classification':
                    $query->byClassifications($id);
                    break;
                case 'artist':
                    $query->byArtists($id);
                    break;
                case 'style':
                    $query->byStyles($id);
                    break;
            }
        }

        $results = $query->getPaginatedModel(self::PER_PAGE_EXPLORE_FURTHER, \App\Models\Api\Artwork::SEARCH_FIELDS);

        // Remove our own element from the collection.
        $item = $this->resource;
        return $results->filter(function($value, $key) use ($item) {
            return ($item->id != $value->id);
        });
    }

    public function collectionUrl($parameters = [])
    {
        $parameters = collect($parameters);

        if ($parameters->isNotEmpty()) {
            foreach ($parameters as $key => $value) {
                if (in_array($key, self::VALID_FILTERS)) {
                    return route('collection', [str_replace('ef-', '', $key) => $value]);
                }
            }
        } else {
            // When no filter selected, use the first filter available.
            $category = key($this->tags());

            // If we have any category to perform filtering, then call the scope
            if ($category) {
                // Parse the ID coming from the tags
                $id = $this->tags()[$category]->keys()->first();

                // Call the appropiate scope
                switch ($category) {
                    case 'classification':
                        return route('collection', ['classification_ids' => $id]);
                        break;
                    case 'artist':
                        return route('collection', ['artist_ids' => $id]);
                        break;
                    case 'style':
                        return route('collection', ['style_ids' => $id]);
                        break;
                }
            }
        }
    }

}
