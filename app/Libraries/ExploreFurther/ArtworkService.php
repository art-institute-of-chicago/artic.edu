<?php

namespace App\Libraries\ExploreFurther;

use App\Models\Api\Search;
use Illuminate\Support\Arr;
use App\Helpers\DateHelpers;

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

        // Build Most Similar Tag
        $tags['most-similar'] = collect(['most-similar' => 'Most Similar']);
        $tags['visually-similar'] = collect(['visually-similar' => 'Visually Similar']);

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
            $tags['artist'] = collect([$artist->title => $artist->title]);
        }

        // Build Date Tags
        if ($this->resource->date_start && $this->resource->date_end) {
            $before = DateHelpers::incrementBefore($this->resource->date_start);
            $after = DateHelpers::incrementAfter($this->resource->date_start);
            $tags['date'] = collect([$this->resource->date_start => DateHelpers::printYear($before) . '–' . DateHelpers::printYear($after)]);
        }

        // Build Color Tags
        // Still a work in progress, so don't show in production
        if (config('aic.show_artwork_color_tag')) {
            if ($this->resource->color) {
                $tags['color'] = collect([$this->resource->color->h . '-' . $this->resource->color->s . '-' . $this->resource->color->l => 'Color']);
            }
        }

        // Preview 'All Tags" to ensure there's something to show
        if ($this->getAllTags()) {
            $tags['all'] = collect([true => 'All Tags']);
        }

        return $tags;
    }

    /**
     * All tags for artworks are built using the following data:
     * artist_title, department_title, classification_titles,
     * style_titles, subject_titles and material_titles
     */
    public function allTags($parameters = [])
    {
        $parameters = collect($parameters);

        // In rare cases, 'All Tags' will be the only tab present
        // If so, render it regardless of the `ef-` param status
        $isAllTagsAnOrphan = (key($this->tags()) === 'all');

        if ($parameters->has('ef-all_ids') || $isAllTagsAnOrphan) {
            return $this->getAllTags();
        }

        return [];
    }

    public function getAllTags()
    {
        $tags = [];

        if ($this->resource->artist_title) {
            $tags[route('collection', ['artist_ids' => $this->resource->artist_title])] = ucfirst($this->resource->artist_title);
        }

        if ($this->resource->department_title) {
            $tags[route('collection', ['department_ids' => $this->resource->department_title])] = ucfirst($this->resource->department_title);
        }

        if ($this->resource->classification_titles) {
            foreach ($this->resource->classification_titles as $item) {
                $tags[route('collection', ['classification_ids' => $item])] = ucfirst($item);
            }
        }

        if ($this->resource->style_titles) {
            foreach ($this->resource->style_titles as $item) {
                $tags[route('collection', ['style_ids' => $item])] = ucfirst($item);
            }
        }

        if ($this->resource->subject_titles) {
            foreach ($this->resource->subject_titles as $item) {
                $tags[route('collection', ['subject_ids' => $item])] = ucfirst($item);
            }
        }

        if ($this->resource->material_titles) {
            foreach ($this->resource->material_titles as $item) {
                $tags[route('collection', ['material_ids' => $item])] = ucfirst($item);
            }
        }

        return Arr::where($tags, function ($key, $value) {
            return !empty($value);
        });
    }
}
