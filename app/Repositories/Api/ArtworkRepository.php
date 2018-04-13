<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artwork;
use App\Models\Api\Search;
use App\Models\Api\Artist;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{
    const PER_PAGE_EXPLORE_FURTHER = 8;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function exploreFurtherCollection($item, $options = [])
    {
        $query = $this->model->query();

        if (!empty($options)) {
            // If we receive any filter, run them all
            $parameters = collect($options);

            $query->byClassifications($parameters->get('exFurther-classification'))
                  ->byArtists($parameters->get('exFurther-artist'))
                  ->byStyles($parameters->get('exFurther-style'));
        } else {
            // When no filter selected, use the first filter available.
            $tags = collect($this->exploreFurtherTags($item));
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
                    case 'artist':
                        $query->byArtists($id);
                        break;
                    case 'style':
                        $query->byStyles($id);
                        break;
                }
            }
        }

        return $query->getSearch(self::PER_PAGE_EXPLORE_FURTHER);
    }

    public function exploreFurtherTags($item)
    {
        $tags = [];

        // Build Classification Tags
        if ($item->classification_id) {
            $exploreFurtherTags = Search::query()->resources(['terms'])->forceEndpoint('search')->byIds($item->classification_id)->get();
            $tags['classification'] = $exploreFurtherTags->mapWithKeys(function ($item) {
                return [$item['id'] => $item['title']];
            });
        }

        // Build Artist Tags
        if ($item->mainArtist && $item->mainArtist->count()) {
            $artist = $item->mainArtist->first();
            $tags['artist'] = [$artist->id => $artist->title];
        }

        // Build Style Tags
        if ($item->style_id) {
            $exploreFurtherTags = Search::query()->resources(['terms'])->byIds($item->style_id)->get();

            $tags['style'] = $exploreFurtherTags->mapWithKeys(function ($item) {
                return [$item['id'] => $item['title']];
            });
        }

        return $tags;
    }

}
