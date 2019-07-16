<?php

namespace App\Repositories\Api;

use App\Models\Api\Search;
use App\Models\Api\Department;
use App\Http\Controllers\DepartmentController;
use App\Repositories\Api\BaseApiRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentRepository extends BaseApiRepository
{
    private $maxArtworks;

    public function __construct(Department $model)
    {
        $this->model = $model;
        $this->maxArtworks = DepartmentController::ARTWORKS_PER_PAGE;
    }

    public function getRelatedArtworks($item)
    {
        // TODO: Can we can get away with a single `mquery` here?
        $customArtworks = $this->getCustomRelatedArtworks($item);

        // We always need to query API, if only to retrieve the total for UI.
        // However, we can get away with not retrieving any artworks!
        $apiPerPage = 0;

        if ($item->should_append_artworks) {
            $this->maxArtworks = min($item->max_artworks, $this->maxArtworks);
            $apiPerPage = max($this->maxArtworks - $customArtworks->count(), 0);
        }

        $apiArtworks = $this->getApiRelatedArtworks($item, $customArtworks, $apiPerPage);

        $relatedArtworks = $customArtworks->merge($apiArtworks->items());
        $relatedArtworks = $relatedArtworks->slice(0, $this->maxArtworks)->values();

        return new LengthAwarePaginator($relatedArtworks, $apiArtworks->total(), $relatedArtworks->count());
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
                    'id' => $excludedArtworks->map(function($excludedArtwork) {
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
}
