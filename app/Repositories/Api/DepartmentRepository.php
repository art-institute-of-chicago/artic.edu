<?php

namespace App\Repositories\Api;

use App\Models\Api\Search;
use App\Models\Api\Department;
use App\Http\Controllers\DepartmentController;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class DepartmentRepository extends BaseApiRepository
{
    private $maxArtworks;

    public function __construct(Department $model)
    {
        $this->model = $model;
        $this->maxArtworks = DepartmentController::ARTWORKS_PER_PAGE;
    }

    public function getRelatedItems($item)
    {
        return $this->getCustomRelatedItems($item)->slice(0, 12)->values();
    }

    public function getRelatedArtworks($item)
    {
        // Defaults for when the department is not augmented
        $customArtworks = collect([]);
        $apiPerPage = $this->maxArtworks;

        if ($item->hasAugmentedModel()) {
            // WEB-2270: Can we can get away with a single `mquery` here?
            $customArtworks = $this->getCustomRelatedArtworks($item);

            // We always need to query API, if only to retrieve the total for UI
            // If there are enough custom related artworks, we don't need results
            $apiPerPage = 0;

            // Department must specify at least one custom artwork,
            // otherwise we will pull them from the API regardless
            if ($customArtworks->count() === 0) {
                $item->should_append_artworks = true;
                $item->max_artworks = $this->maxArtworks;
            }

            if ($item->should_append_artworks) {
                $this->maxArtworks = min($item->max_artworks, $this->maxArtworks);
                $apiPerPage = max($this->maxArtworks - $customArtworks->count(), 0);
            }
        }

        $apiArtworks = $this->getApiRelatedArtworks($item, $customArtworks, $apiPerPage);

        $relatedArtworks = $customArtworks->merge($apiArtworks->items());
        $relatedArtworks = $relatedArtworks->slice(0, $this->maxArtworks)->values();

        // Added `max` to `perPage` to avoid "division by zero" error
        return new LengthAwarePaginator($relatedArtworks, $apiArtworks->total(), max($relatedArtworks->count(), 1));
    }

    private function getCustomRelatedArtworks($item)
    {
        return $item->apiModels('customRelatedArtworks', 'Artwork');
    }

    /**
     * Query for artworks that haven't been explicitly linked.
     */
    private function getApiRelatedArtworks($item, $excludedArtworks, $perPage)
    {
        $query = [
            'bool' => [
                'must' => [
                    'term' => [
                        'department_id' => $item->id,
                    ],
                ],
            ],
        ];

        if (isset($excludedArtworks)) {
            $query['bool']['must_not'] = [
                'terms' => [
                    'id' => $excludedArtworks->map(function ($excludedArtwork) {
                        return $excludedArtwork->id;
                    })->filter()->values()->all()
                ],
            ];
        }

        return Search::query()
            ->resources(['artworks'])
            ->rawSearch($query)
            ->forceEndpoint('search')
            ->getSearch($perPage);
    }

    /**
     * TODO: De-dupe w/ ArtistRepository?
     */
    public function getCustomRelatedItems($item)
    {
        $relatedItems = $item->getRelatedWithApiModels('related_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
            'experiences' => [
                'apiModel' => 'App\Models\Experience',
                'routePrefix' => 'collection.interactive_features',
                'moduleName' => 'experiences',
            ],
        ], [
            // @see HasApiRelations::$typeUsesApi
            'exhibitions' => true,
            'articles' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
            'videos' => false,
            'experiences' => false,
        ]) ?? collect([]);

        $now = Carbon::now();

        $relatedItems = $relatedItems->filter(function ($relatedItem) use ($now) {
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
                case \App\Models\Experience::class:
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
}
