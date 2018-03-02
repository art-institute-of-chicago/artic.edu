<?php

function aic_addToRecentlyViewedArtworks($item)
{
    $recentlyViewed = session('recently_viewed_artwork');
    if ($recentlyViewed == null) {
        $recentlyViewed = collect([]);
    }

    // remove the id if it was previously viewed
    $recentlyViewed = $recentlyViewed->filter(function ($value, $key) use($item){
        return $value->id != $item->id;
    });

    // add it to beginning of list
    $recentlyViewed->prepend($item);

    // keep 20 items
    $recentlyViewed = $recentlyViewed->slice(0, 100);

    session(['recently_viewed_artwork' => $recentlyViewed]);
}

function aic_getRecentlyViewedArtworks()
{
    $recentlyViewed = session('recently_viewed_artwork');
    if ($recentlyViewed == null) {
        $recentlyViewed = collect([]);
    }

    return $recentlyViewed;
}

function aic_clearRecentlyViewedArtworks()
{
    session(['recently_viewed_artwork' => collect([])]);
}


function aic_addIdToRecentlyViewedArtworks($id)
{
    $recentlyViewed = session('recently_viewed_artwork_ids');
    if ($recentlyViewed == null) {
        $recentlyViewed = collect([]);
    }

    // remove the id if it was previously viewed
    $recentlyViewed = $recentlyViewed->filter(function ($value, $key) use($id){
        return $value['id']!=$id;
    });

    // add it to beginning of list
    $recentlyViewed->prepend(['id' => $id]);

    // keep 100 items
    $recentlyViewed = $recentlyViewed->slice(0, 100);

    session(['recently_viewed_artwork_ids' => $recentlyViewed]);
}

function aic_getRecentlyViewedArtworkIds()
{
    $recentlyViewed = session('recently_viewed_artwork_ids');
    if ($recentlyViewed == null) {
        $recentlyViewed = collect([]);
    }

    return $recentlyViewed;
}

function aic_clearRecentlyViewedArtworkIds()
{
    session(['recently_viewed_artwork_ids' => collect([])]);
}
