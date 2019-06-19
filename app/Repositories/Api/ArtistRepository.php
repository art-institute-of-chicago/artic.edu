<?php

namespace App\Repositories\Api;

use App\Models\Api\Artist;
use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class ArtistRepository extends BaseApiRepository
{

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function getRelatedItems($item)
    {
        $relatedItems = $this->getCustomRelatedItems($item);

        $hiddenItems = $item->getRelatedWithApiModels('hidden_related_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'exhibitions' => true,
        ]) ?? collect([]);

        $excludedItems = $relatedItems->merge($hiddenItems);

        $apiItems = $this->getApiRelatedItems($item, $excludedItems);

        return $relatedItems->merge($apiItems);
    }

    public function getCustomRelatedItems($item)
    {
        $relatedItems = $item->getRelatedWithApiModels('related_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            // See $typeUsesApi in HasApiRelations class
            'exhibitions' => true,
            'articles' => false,
            'digitalLabels' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
        ]) ?? collect([]);

        foreach ($relatedItems as $relatedItem) {
            switch (get_class($relatedItem)) {
                case \App\Models\Article::class:
                    $relatedItem->subtype = 'Article';
                    break;
                case \App\Models\DigitalPublication::class:
                    $relatedItem->subtype = 'Digital Publication';
                    break;
                case \App\Models\PrintedPublication::class:
                    $relatedItem->subtype = 'Print Publication';
                    break;
                case \App\Models\EducatorResource::class:
                    $relatedItem->subtype = 'Educator Resource';
                    break;
                case \App\Models\DigitalLabel::class:
                    $relatedItem->subtype = 'Interactive Feature';
                    break;
            }

            // Default to 'article' i/o 'generic' for default image
            $relatedItem->type = $relatedItem->type ?? 'article';
        }

        return $relatedItems;
    }

    /**
     * Query for exhibitions that haven't been explicitly linked.
     */
    public function getApiRelatedItems($item, $excludedItems = null)
    {
        $query = [
            'bool' => [
                'must' => [
                    'term' => [
                        'artist_ids' => $item->id,
                    ],
                ],
            ],
        ];

        if (isset($excludedItems)) {
            $query['bool']['must_not'] = [
                'terms' => [
                    'id' => $excludedItems->map(function($excludedItem) {
                        if (get_class($excludedItem) == \App\Models\Api\Exhibition::class) {
                            return $excludedItem->datahub_id;
                        }
                    })->filter()->values()->all()
                ],
            ];
        }

        return Search::query()
            ->exhibitionGlobal()
            ->exhibitionOrderByDate('desc')
            ->resources(['exhibitions'])
            ->rawSearch($query)
            ->getPaginatedModel(500, \App\Models\Api\Exhibition::SEARCH_FIELDS)
            ->items();
    }
}
