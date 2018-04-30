<?php

namespace App\Repositories\Behaviors;
use App\Models\Api\Search;

trait ExploreFurtherTags
{
    protected $artworks;

    public function getArtworks($item)
    {
        // Memoize to avoid double callings
        if (!$this->artworks) {
            $this->artworks = $this->getArtworksCollection($item);
        }

        return $this->artworks;
    }

    public function exploreFurtherTags($element)
    {
        $tags = collect([]);

        // Build Classification Tags
        if ($element->id) {
            $results = $this->getArtworks($element->id);

            foreach($results->getMetadata('aggregations')->classifications->buckets as $item) {
                $tags = $tags->merge(
                    [$item->key => (ucfirst($item->key) . ' (' . $item->doc_count . ')')]
                );
            };
        }

        return [ 'classification' => $tags ];
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
