<?php

namespace App\Libraries;

use App\Models\Api\Exhibition;
use App\Models\Api\Search;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
use App\Models\EducatorResource;
use App\Models\PrintedPublication;
use Illuminate\Support\Collection;

/**
 * Auto-derived "Art Institute Publications" and "Art Institute Exhibitions"
 * sections for an artwork.
 *
 * These lists are what the website shows when nothing is curated manually (and
 * they append after the manual selections when it is). Both the front-end
 * artwork controller and the Twill form consume them so the CMS preview always
 * matches the published page.
 */
class ArtworkSectionService
{
    /**
     * Publications related to the artwork through its `relatedArtworks` API
     * relation, including parent publications of linked articles, newest first.
     *
     * @param int $artworkId The artwork's datahub id.
     *
     * @return Collection<int, DigitalPublication|PrintedPublication>
     */
    public static function autoPublications(int $artworkId): Collection
    {
        if (empty($artworkId)) {
            return collect();
        }

        $relatedToArtwork = function ($query) use ($artworkId) {
            return $query
                ->where('api_relatables.relation', 'relatedArtworks')
                ->where('api_relations.datahub_id', $artworkId);
        };

        $digital = DigitalPublication::published()
            ->notUnlisted()
            ->whereHas('apiElements', $relatedToArtwork)
            ->get();

        $printed = PrintedPublication::published()
            ->whereHas('apiElements', $relatedToArtwork)
            ->get();

        // Roll up linked Digital Publication Articles to their parent
        // publications: the module shows publications, not individual entries.
        $articlePublicationIds = DigitalPublicationArticle::query()
            ->whereHas('apiElements', $relatedToArtwork)
            ->pluck('digital_publication_id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (!empty($articlePublicationIds)) {
            $rolledUp = DigitalPublication::published()
                ->notUnlisted()
                ->whereIn('id', $articlePublicationIds)
                ->get();

            $digital = $digital->concat($rolledUp);
        }

        return collect($digital)
            ->concat($printed)
            ->unique(function ($publication) {
                return class_basename($publication) . ':' . $publication->id;
            })
            ->sortByDesc(function ($publication) {
                // Null dates sort after dated publications.
                return $publication->publication_date ?? '';
            })
            ->values();
    }

    /**
     * Educator Resources related to the artwork through its `relatedArtworks`
     * API relation, newest first.
     *
     * @param int $artworkId The artwork's datahub id.
     *
     * @return Collection<int, EducatorResource>
     */
    public static function autoEducatorResources(int $artworkId): Collection
    {
        if (empty($artworkId)) {
            return collect();
        }

        return EducatorResource::published()
            ->whereHas('apiElements', function ($query) use ($artworkId) {
                return $query
                    ->where('api_relatables.relation', 'relatedArtworks')
                    ->where('api_relations.datahub_id', $artworkId);
            })
            ->orderByDesc('publish_start_date')
            ->get()
            ->values();
    }

    /**
     * Exhibitions related to the artwork, as returned by the `artwork_ids`
     * search, newest first.
     *
     * @param int $artworkId The artwork's datahub id.
     *
     * @return Collection<int, Exhibition>
     */
    public static function autoExhibitions(int $artworkId): Collection
    {
        if (empty($artworkId)) {
            return collect();
        }

        $query = [
            'bool' => [
                'must' => [
                    'term' => [
                        'artwork_ids' => $artworkId,
                    ],
                ],
            ],
        ];

        $exhibitions = Search::query()
            ->exhibitionGlobal()
            ->exhibitionOrderByDate('desc')
            ->resources(['exhibitions'])
            ->rawSearch($query)
            ->getPaginatedModel(100, Exhibition::SEARCH_FIELDS)
            ->items();

        // Keep the same published-augmented-model filter the ArtistRepository
        // applies to exhibitions it discovers from the API.
        $exhibitions = array_filter($exhibitions, function ($exhibition) {
            if ($exhibition->hasAugmentedModel() && $exhibition->getAugmentedModel()) {
                return $exhibition->getAugmentedModel()->published;
            }

            return true;
        });

        return collect($exhibitions)->values();
    }
}
