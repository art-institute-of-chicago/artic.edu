<?php

namespace App\Libraries;
use Cache;

/**
 *
 * Service used to retrieve, add and remove elements to the Recently Viewed collection.
 *
 */

class RecentlyViewedService
{

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
        session(['recently_viewed_artwork' => collect([])]);
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

}
