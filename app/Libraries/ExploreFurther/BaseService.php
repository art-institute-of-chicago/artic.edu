<?php

namespace App\Libraries\ExploreFurther;

use App\Models\Api\Search;

use Illuminate\Support\Str;

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
        'ef-style_ids',
        'ef-place_ids',
        'ef-date_ids',
        'ef-color_ids',
        'ef-most-similar_ids',
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
        $tags = [];

        if (get_class($this->resource) == \App\Models\Api\Artist::class) {
            // Build Most Similar Tag
            $tags['most-similar'] = collect(['most-similar' => 'Most Similar']);

            // Build Style Tag
            $style = $this->resource->artworks()->getMetadata('aggregations')->styles->buckets[0]->key ?? false;
            if ($style) {
                $tags['style'] = collect([$style => $style]);
            }

            // Build Place tag
            $place = $this->resource->artworks()->getMetadata('aggregations')->place_of_origin->buckets[0]->key ?? false;
            if ($place) {
                $tags['place'] = collect([$place => $place]);
            }

            // Build Date Tags
            if ($this->resource->birth_date && $this->resource->birth_date) {
                $tags['date'] = collect([$this->resource->birth_date .'|' .$this->resource->death_date => printYear($this->resource->birth_date) ."–" .printYear($this->resource->death_date)]);
            }
        }
        else {
            // Build Classification Tags
            $classification = collect([]);
            if ($this->resource->id) {
                foreach($this->aggregations()->classifications->buckets as $index => $item) {
                    if ($index == self::MAX_TAGS) {
                        break;
                    }

                    $classification = $classification->merge(
                        [$item->key => ucfirst($item->key)]
                    );
                };
            }
            $tags['classification'] = $classification;
        }

        return $tags;
    }

    public function collection($parameters = [])
    {
        $parameters = collect($parameters);

        $query = Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search');

        $active = $parameters->filter(function($value, $key) {
            return Str::contains($key, 'ef-');
        })->isNotEmpty();

        if ($active) {
            if ($parameters->get('ef-most-similar_ids')) {
                $query->byMostSimilar($this->resource->id, get_class($this->resource));
            }
            else {
                $years = explode('|', $parameters->get('ef-date_ids'));

                $beforeYear = Str::contains($parameters->get('ef-date_ids'), '|') ? $years[0] : incrementBefore($parameters->get('ef-date_ids'));
                $afterYear = Str::contains($parameters->get('ef-date_ids'), '|') ? $years[1] : incrementAfter($parameters->get('ef-date_ids'));

                $query->byClassifications($parameters->get('ef-classification_ids'))
                    ->byArtists($parameters->get('ef-artist_ids'))
                    ->byStyles($parameters->get('ef-style_ids'))
                    ->byPlaces($parameters->get('ef-place_ids'))
                    ->yearRange($beforeYear, $afterYear)
                    ->byColor($parameters->get('ef-color_ids'));
            }
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
                case 'place':
                    $query->byPlaces($id);
                    break;
                case 'date':
                    $query->dateRange(incrementBefore($id), incrementAfter($id));
                    break;
                case 'color':
                    $query->byColor($id);
                    break;
                case 'most-similar':
                    $query->byMostSimilar($this->resource->id, get_class($this->resource));
                    break;
            }
        }

        $results = $query->getPaginatedModel(self::PER_PAGE_EXPLORE_FURTHER, \App\Models\Api\Artwork::SEARCH_FIELDS);

        // Remove our own element from the collection, but only if there's more than one result
        if ($results->count() > 1) {
            $item = $this->resource;
            $results = $results->filter(function($value, $key) use ($item) {
                return ($item->id != $value->id);
            });
        }

        return $results;
    }

    public function collectionUrl($parameters = [])
    {
        $parameters = collect($parameters);

        if ($parameters->isNotEmpty()) {
            foreach ($parameters as $key => $value) {
                if (in_array($key, self::VALID_FILTERS)) {
                    switch ($key) {
                        case 'ef-date_ids':
                            return route('collection', ['date-start' => str_replace(' ','', printYear(incrementBefore($value))),
                                                        'date-end' => str_replace(' ', '', printYear(incrementAfter($value)))]);
                            break;
                        case 'ef-color_ids':
                            return route('collection', ['color' => $value]);
                            break;
                        default:
                            return route('collection', [str_replace('ef-', '', $key) => $value]);
                    }
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
                    case 'place':
                        return route('collection', ['place_ids' => $id]);
                        break;
                    case 'date':
                        return route('collection', ['date-start' => incrementBefore($id), 'date-end' => incrementAfter($id)]);
                        break;
                    case 'color':
                        return route('collection', ['color' => $id]);
                        break;
                }
            }
        }
    }

}
