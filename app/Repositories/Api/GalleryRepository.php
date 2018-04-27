<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Gallery;
use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class GalleryRepository extends BaseApiRepository
{
    const PER_PAGE_EXPLORE_FURTHER = 20;
    const ARTWORKS_PER_PAGE = 8;

    protected $artworks;

    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }

    public function getArtworks($galleryId)
    {
        // Memoize to avoid double callings
        if (!$this->artworks) {
            $this->artworks = Search::query()
                ->resources(['artworks'])
                ->forceEndpoint('search')
                ->byGalleryIds($galleryId)
                ->aggregationClassifications()
                ->getSearch(self::ARTWORKS_PER_PAGE);
        }

        return $this->artworks;
    }

    public function exploreFurtherTags($galleryId)
    {
        $tags = collect([]);

        // Build Classification Tags
        if ($galleryId) {
            $results = $this->getArtworks($galleryId);

            foreach($results->getMetadata('aggregations')->classifications->buckets as $item) {
                $tags = $tags->merge(
                    [$item->key => (ucfirst($item->key) . ' (' . $item->doc_count . ')')]
                );
            };
        }

        return [ 'classification' => $tags ];
    }

    public function exploreFurtherCollection($galleryId, $options = [])
    {
        $query = Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search');

        if (!empty($options)) {
            $parameters = collect($options);
            $query->byClassifications($parameters->get('exFurther-classification'));
        } else {
            // When no filter selected, use the first filter available.
            $tags = collect($this->exploreFurtherTags($galleryId));
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
