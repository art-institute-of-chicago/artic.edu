<?php

namespace App\Repositories\Api;

use Carbon\Carbon;
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

        return $relatedItems->merge($apiItems)->slice(0, 12)->values();
    }

    /**
     * TODO: De-dupe w/ DepartmentRepository?
     */
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
            'videos' => false,
        ]) ?? collect([]);

        $now = Carbon::now();

        $relatedItems = $relatedItems->filter(function($relatedItem) use ($now) {
            // We check if the exhibitions are published in `getApiRelatedItems`
            if (get_class($relatedItem) === \App\Models\Api\Exhibition::class) {
                return true;
            }

            $isPublished = isset($relatedItem->published) && $relatedItem->published;
            $isVisible = (
                !$relatedItem->isFillable('publish_start_date') ||
                !isset($relatedItem->publish_start_date) ||
                $relatedItem->publish_start_date < $now
            ) && (
                !$relatedItem->isFillable('publish_end_date') ||
                !isset($relatedItem->publish_end_date) ||
                $relatedItem->publish_end_date > $now
            );

            return $isPublished && $isVisible;
        })->values();

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
                case \App\Models\Video::class:
                    $relatedItem->subtype = 'Video';
                    break;
            }

            $relatedItem->type = $relatedItem->type ?? 'generic';
            $relatedItem->intro = $relatedItem->shortDesc = $relatedItem->listing_description = null;
            $relatedItem->date = null;
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
                        switch (get_class($excludedItem)) {
                            case \App\Models\Api\Exhibition::class:
                                return $excludedItem->id;
                                break;
                            case \App\Models\Exhibition::class:
                                return $excludedItem->datahub_id;
                                break;
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
            ->getPaginatedModel(100, \App\Models\Api\Exhibition::SEARCH_FIELDS)
            ->items();
    }
}
