<?php

namespace App\Libraries\ExploreFurther;
use App\Models\Api\Search;

/**
 *
 * Service used to retrieve explore further elements.
 * For artworks it works a little different than for the rest.
 *
 * Tags are using just one style, one classification and one artist.
 * All tags are built with several classifications (see function allTags)
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

        $tags['all'] = [true => 'All Tags'];

        return $tags;
    }

    public function allTags($parameters = [])
    {
        // All tags for artworks are built using the following data:
        // artist_title, department_title, classification_titles,
        // style_titles, subject_titles and material_titles

        $parameters = collect($parameters);
        $tags = [];

        if ($parameters->has('ef-all_ids')) {

            $tags[route('collection', ['artist_ids' => $this->resource->artist_title])] = ucfirst($this->resource->artist_title);
            $tags[route('collection', ['department_ids' => $this->resource->department_title])] = ucfirst($this->resource->department_title);

            foreach ($this->resource->classification_titles as $item) {
                $tags[route('collection', ['classification_ids' => $item])] = ucfirst($item);
            }

            foreach ($this->resource->style_titles as $item) {
                $tags[route('collection', ['style_ids' => $item])] = ucfirst($item);
            }

            foreach ($this->resource->subject_titles as $item) {
                $tags[route('collection', ['subject_ids' => $item])] = ucfirst($item);
            }

            foreach ($this->resource->material_titles as $item) {
                $tags[route('collection', ['material_ids' => $item])] = ucfirst($item);
            }
        }

        return array_where($tags, function($key, $value) {
            return !empty($value);
        });
    }


}
