<?php

namespace App\Libraries;
use Cache;
use App\Models\Api\Search;

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
    function addArtwork($item)
    {
        $recentlyViewed = session('recently_viewed_artwork') ?? collect([]);

        // Remove the id if it was previously viewed
        $recentlyViewed = $recentlyViewed->filter(function ($value, $key) use( $item ) {
            return $value->id != $item->id;
        });

        // Add it to beginning of list
        $recentlyViewed->prepend($item);

        // Keep 20 items max
        $recentlyViewed = $recentlyViewed->slice(0, 20);

        session(['recently_viewed_artwork' => $recentlyViewed]);
    }

    /**
     * Clear all elements
     *
     * @return null
     */
    function clear()
    {
        session()->forget('recently_viewed_artwork');
    }

    /**
     * Get the full list of recently viewed artworks
     *
     * @return null
     */
    function getArtworks()
    {
        return session('recently_viewed_artwork') ?? collect([]);
    }

    /**
     * Process and get the Themes this user might be interested in.
     *
     * @return null
     */
    function getThemes()
    {
        $themes = [];
        $ids    = $this->getArtworks()->pluck('id')->toArray();

        // If we have recently viewed elements
        if (!empty($ids)) {

            // Let's aggregate on them to get better suggestions
            $tags = Search::query()
                ->forceEndpoint('search')
                ->resources(['artworks'])
                ->allAggregations(self::THEMES_PER_CATEGORY)
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
                            'href'  => route('collection', ['artist_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];
                        break;
                    case 'departments':
                        $themes[] = [
                            'href'  => route('collection', ['department_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];
                        break;
                    case 'styles':
                        $themes[] = [
                            'href'  => route('collection', ['style_ids' => $elementKey]),
                            'label' => ucfirst($elementKey)
                        ];
                        break;
                }
            }
        }

        return $themes;

    }

}
