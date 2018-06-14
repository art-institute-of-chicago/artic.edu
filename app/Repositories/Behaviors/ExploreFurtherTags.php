<?php

namespace App\Repositories\Behaviors;
use App\Models\Api\Search;

trait ExploreFurtherTags
{
    protected $artworks;
    protected $maxTags = 3;

    public function getArtworks($item)
    {
        // Memoize to avoid double callings
        if (!$this->artworks) {
            $this->artworks = $this->getArtworksCollection($item);
        }

        return $this->artworks;
    }

    public function exploreFurtherAllTags($item)
    {
        // Use same query as search to hit the cache instead of creating a new one.
        $exploreFurtherTags = $this->getArtworksCollection($item);
        $buckets = $exploreFurtherTags->getMetadata('aggregations')->classifications->buckets;

        return collect($buckets)->mapWithKeys(function ($item) {
            return [$item->key => ucfirst($item->key)];
        });
    }

    public function exploreFurtherTags($element)
    {
        $tags = collect([]);

        // Build Classification Tags
        if ($element->id) {
            $results = $this->getArtworks($element);

            foreach($results->getMetadata('aggregations')->classifications->buckets as $index => $item) {
                if ($index == $this->maxTags) {
                    break;
                }

                $tags = $tags->merge(
                    [$item->key => ucfirst($item->key)]
                );
            };
        }

        return [
            'classification' => $tags,
            'all' => [true => 'All Tags']
        ];
    }

    public function exploreFurtherCollection($element, $options = [])
    {
        $query = Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search');

        if (!empty($options)) {
            $parameters = collect($options);
            $query->byClassifications($parameters->get('exFurther-classification'));
        } else {
            // When no filter selected, use the first filter available.
            $tags = collect($this->exploreFurtherTags($element));
            $category = $tags->keys()->first();

            // If we have any category to perform filtering, then call the scope
            if ($category) {
                // Parse the ID coming from the tags
                $id = collect($tags->first())->keys()->first();

                // Call the appropiate scope
                switch ($category) {
                    case 'classification':
                        $query->byClassifications($id);
                        break;
                }
            }
        }

        return $query->getSearch(self::PER_PAGE_EXPLORE_FURTHER);
    }
}
