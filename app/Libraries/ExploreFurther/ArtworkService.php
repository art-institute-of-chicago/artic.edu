<?php

namespace App\Libraries\ExploreFurther;
use App\Models\Api\Search;

/**
 *
 * Service used to retrieve explore further elements.
 * Tags, artworks, view more link and 'All tags' list
 *
 */

class ArtworkService extends BaseService
{

    public function tags()
    {
        $tags = [];

        // Build Style Tags
        if ($this->resource->style_id) {
            $exploreFurtherTags = Search::query()->resources(['category-terms'])->byIds($this->resource->style_id)->get();

            $tags['style'] = $exploreFurtherTags->mapWithKeys(function ($item) {
                return [$item['title'] => $item['title']];
            });
        }

        // Build Classification Tags
        if ($this->resource->classification_id) {
            $exploreFurtherTags = Search::query()->resources(['category-terms'])->forceEndpoint('search')->byIds($this->resource->classification_id)->get();
            $tags['classification'] = $exploreFurtherTags->mapWithKeys(function ($item) {
                return [$item['title'] => $item['title']];
            });
        }

        // Build Artist Tags
        if ($this->resource->mainArtist && $this->resource->mainArtist->count()) {
            $artist = $this->resource->mainArtist->first();
            $tags['artist'] = [$artist->title => $artist->title];
        }

        return $tags;
    }


}
