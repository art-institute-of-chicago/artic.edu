<?php

namespace App\Models\Behaviors;

use App\Models\Article;
use App\Models\Selection;
use App\Models\Event;
use App\Models\Api\Exhibition;
use App\Models\Experience;
use App\Models\DigitalPublication;
use App\Models\Video;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

/**
 * WEB-1415: Requires HasApiRelations and HasRelations.
 */
trait HasFeaturedRelated
{
    private $selectedFeaturedRelateds;

    private $isFeaturedRelatedRecentContent = false;

    public function isFeaturedRelatedRecentContent()
    {
        return $this->isFeaturedRelatedRecentContent;
    }

    public function hasFeaturedRelated()
    {
        return !empty($this->featuredRelated);
    }

    public function getFeaturedRelatedAttribute()
    {
        if ($this->selectedFeaturedRelateds) {
            return $this->selectedFeaturedRelateds;
        }

        $relatedItems = $this->getCustomRelatedItems();

        if ($relatedItems->count() < 1) {
            $relatedItems = $this->getDefaultRelatedItems();
            $this->isFeaturedRelatedRecentContent = true;
        }

        $this->selectedFeaturedRelateds = $this->getLabeledRelatedItems($relatedItems);

        return $this->selectedFeaturedRelateds;
    }

    private function getCustomRelatedItems()
    {
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
            'experiences' => false,
            'digitalPublications' => false,
            'videos' => false,
        ]) ?? collect([]);

        $now = Carbon::now();

        // Filter out any unpublished items!
        $relatedItems = $relatedItems->filter(function($relatedItem) use ($now) {
            // TODO: Verify that we don't need to check if the exhibition is in the future?
            if (get_class($relatedItem) === \App\Models\Api\Exhibition::class) {
                return true;
            }

            if (get_class($relatedItem) === \App\Models\Api\Event::class) {
                if (!$relatedItem->isFuture) {
                    return false;
                }
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

        return $relatedItems;
    }

    private function getDefaultRelatedItems()
    {
        // Update pool of most recent items once each day
        $recentItems = Cache::remember('default-related-pool', 60 * 60 * 24, function() {
            $poolSize = 20;

            // WEB-2018: Do we need to check published date, or is it ok to just keep checking updated_at?
            $articles = Article::published()->visible()->notUnlisted()->orderBy('updated_at', 'desc')->limit($poolSize)->get();
            $selections = Selection::published()->visible()->notUnlisted()->orderBy('updated_at', 'desc')->limit($poolSize)->get();
            $experiences = Experience::published()->visible()->notUnlisted()->orderBy('updated_at', 'desc')->limit($poolSize)->get();
            $videos = Video::published()->visible()->orderBy('updated_at', 'desc')->limit($poolSize)->get();

            $pool = collect([])
                ->merge($articles)
                ->merge($selections)
                ->merge($experiences)
                ->merge($videos)
                ->sortBy('updated_at')
                ->reverse()
                ->slice(0,$poolSize)
                ->values();

            return $pool;
        });

        return $recentItems
            ->filter(function($item) {
                return get_class($item) !== get_class($this) || $item->id !== $this->id;
            })
            ->random(3)
            ->values();
    }

    private function getLabeledRelatedItems($relatedItems)
    {
        $labeledRelatedItems = [];

        $relatedItems->each(function ($relatedItem) use (&$labeledRelatedItems) {
            switch (get_class($relatedItem)) {
                case Article::class:
                    // Tag is often "In the Lab", "Collection Spotlight", etc.
                    $label = 'Article';
                    $type = 'article';
                    break;
                case Selection::class:
                    $label = null;
                    $type = 'selection';
                    break;
                case Event::class:
                    // Tag is replaced by "Tour", "Member Exclusive", etc.
                    $label = 'Event';
                    $type = 'event';
                    break;
                case Exhibition::class:
                    // Tag is often "Closed", "Ongoing", "Closing soon", etc.
                    $label = 'Exhibition';
                    $type = 'exhibition';
                    break;
                case Experience::class:
                    // Tag is "Interactive Feature"
                    $label = null;
                    $type = 'experience';
                    break;
                case DigitalPublication::class:
                    // No tag
                    $label = 'Digital Publication';
                    $type = 'generic';
                    break;
                case Video::class:
                    // Tag is "Video"
                    $label = 'Media';
                    $type = 'media';
                    break;
                default:
                    throw new \Exception('Cannot determine sidebar item type');
                    break;
            }

            $labeledRelatedItems[] = [
                'label' => $label ?? 'Content',
                'type' => $type,
                'item' => $relatedItem,
            ];
        });

        return $labeledRelatedItems;
    }

}
