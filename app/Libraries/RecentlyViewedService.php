<?php

namespace App\Libraries;

use App\Models\Api\Search;
use Illuminate\Support\Facades\Cookie;

/**
 *
 * Service used to retrieve, add and remove elements to the Recently Viewed collection.
 *
 */

class RecentlyViewedService
{
    const THEMES_PER_CATEGORY = 3;

    /**
     * Add a new item to the recently viewed collection
     *
     * @param  App\Models\Api\Artwork $item
     * @return null
     */
    public function addArtwork($item)
    {
        $recentlyViewed = $this->getArtworkIds();

        // Remove the id if it was previously viewed
        $recentlyViewed = $recentlyViewed->filter(function ($value, $key) use ($item) {
            return $value != $item->id;
        });

        // Add it to beginning of list
        $recentlyViewed->prepend($item->id);

        // Keep 20 items max
        $recentlyViewed = $recentlyViewed->slice(0, 20);

        Cookie::queue('recently_viewed_artwork', json_encode($recentlyViewed), 60 * 24 * 14); // 14 days
    }

    /**
     * Clear all elements
     *
     * @return null
     */
    public function clear()
    {
        Cookie::queue('recently_viewed_artwork', '', 1);
    }

    /**
     * Get the full list of recently viewed artworks
     *
     * @return null
     */
    public function getArtworkIds()
    {
        $cookie = Cookie::get('recently_viewed_artwork');

        $ids = json_decode($cookie);

        if (!$ids) {
            return collect([]);
        }

        return collect($ids);
    }

    public function getArtworks()
    {
        $ids = $this->getArtworkIds()->take(12);

        if ($ids->isEmpty()) {
            return collect([]);
        }

        $artworks = \App\Models\Api\Artwork::query()->findMany($ids->toArray());

        $artworksSorted = [];
        foreach ($ids as $id) {
            $artworksSorted[] = $artworks->firstWhere('id', $id);
        }

        return collect($artworksSorted)->filter();
    }

    /**
     * Process and get the Themes this user might be interested in.
     *
     * @return null
     */
    public function getThemes()
    {
        $themes = [];
        $ids = $this->getArtworkIds()->toArray();

        // If we have recently viewed elements
        if (!empty($ids)) {

            // Let's aggregate on them to get better suggestions
            $tags = Search::query()
                ->forceEndpoint('search')
                ->resources(['artworks'])
                ->allAggregations()
                ->byArtworkIds($ids)
                ->forPage(1, 0)
                ->get();

            // Finally let's build collection links for artists, departments and styles.
            foreach ($tags->getMetadata('aggregations') as $bucket => $data) {
                // Let's just use the first element of each bucket

                if (empty(head($data->buckets))) {
                    continue;
                }
                $elementKey = head($data->buckets)->key;

                // We only care about the following aggregations. Please see allAggregations scope at Api/Search
                // in case you want to add more here.
                switch ($bucket) {
                    case 'artists':
                        $themes[] = [
                            'href' => route('collection', ['artist_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];

                        break;
                    case 'departments':
                        $themes[] = [
                            'href' => route('collection', ['department_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];

                        break;
                    case 'styles':
                        $themes[] = [
                            'href' => route('collection', ['style_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];

                        break;
                }
            }
        }

        return $themes;
    }
}
