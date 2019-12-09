<?php

namespace App\Models\Behaviors;

use Carbon\Carbon;

/**
 * WEB-1415: Requires HasApiRelations and HasRelations.
 */
trait HasFeaturedRelated
{
    protected $selectedFeaturedRelated;

    /**
     * Select a random element from the relationships below and return one per request.
     * Adapted from \App\Repositories\Api\ArtistRepository::getCustomRelatedItems()
     */
    public function getFeaturedRelatedAttribute()
    {
        if ($this->selectedFeaturedRelated) {
            return $this->selectedFeaturedRelated;
        }

        $relatedItems = $this->getRelatedWithApiModels('sidebar_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            // See $typeUsesApi in HasApiRelations class
            'articles' => false,
            'selections' => false,
            'events' => false,
            'exhibitions' => true, // API!
            'interactiveFeatures.experiences' => false,
            'videos' => false,
        ]) ?? collect([]);

        $now = Carbon::now();

        // Filter out any unpublished items!
        $relatedItems = $relatedItems->filter(function($relatedItem) use ($now) {
            // TODO: Verify that we don't need to check if the exhibition is in the future?
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

        // Exit early if there's nothing to show
        if ($relatedItems->count() < 1) {
            return;
        }

        // We only want a random one that's valid...
        $relatedItem = $relatedItems->random();

        switch (get_class($relatedItem)) {
            case \App\Models\Article::class:
                // Tag is often "In the Lab", "Collection Spotlight", etc.
                $label = 'Article';
                $type = 'article';
                break;
            case \App\Models\Selection::class:
                $label = null;
                $type = 'selection';
                break;
            case \App\Models\Event::class:
                // Tag is replaced by "Tour", "Member Exclusive", etc.
                $label = 'Event';
                $type = 'event';
                break;
            case \App\Models\Api\Exhibition::class:
                // Tag is often "Closed", "Ongoing", "Closing soon", etc.
                $label = 'Exhibition';
                $type = 'exhibition';
                break;
            case \App\Models\Experience::class:
                // Tag is "Interactive Feature"
                $label = null;
                $type = 'experience';
                break;
            case \App\Models\Video::class:
                // Tag is "Video"
                $label = 'Media';
                $type = 'media';
                break;
            default:
                throw new \Exception('Cannot determine sidebar item type');
                break;
        }

        return $this->selectedFeaturedRelated = [
            'label' => $label ?? 'Content',
            'type' => $type,
            'items' => [
                $relatedItem,
            ],
        ];
    }

}
