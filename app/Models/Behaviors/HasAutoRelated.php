<?php

namespace App\Models\Behaviors;

use App\Models\Vendor\Block;
use Illuminate\Support\Str;
use A17\Twill\Models\RelatedItem;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasAutoRelated
{
    public function related($id)
    {
        $relatedItems = [];

        // Resolve the model & class
        $modelName = Str::plural(Str::lower(class_basename(get_class($this))));
        $modelClass = '\\App\\Models\\' . Str::singular(ucfirst($modelName));

        if (class_exists($modelClass)) {
            $item = $modelClass::published()->find((int) $id);
        }

        // Set scope to only include blockable types that can be related to
        $blockableTypes = [
            'highlights',
            'educatorResources',
            'articles',
            'videos',
            'researchGuides',
            'genericPages',
            'events',
            'exhibitions',
        ];

        // Get all blocks that have this model as a related item
        $relatedBlockItems = Block::whereIn('blockable_type', $blockableTypes)
            ->where('type', Str::singular($modelName))
            ->get()
            ->filter(function ($block) use ($modelName, $id, $item) {
                $content = $block->content;
                return isset($content['browsers'], $content['browsers'][$modelName]) &&
                    (in_array($id, $content['browsers'][$modelName]) || in_array($item->datahub_id, $content['browsers'][$modelName]));
            });

        foreach ($relatedBlockItems as $relatedBlockItem) {
            $relatedItems[] = $relatedBlockItem->blockable;
        }

        // Get all sidebar items that have this model as a related item
        $editorialTypes = [
            'articles',
            'highlights',
            'events',
            'exhibitions',
            'experiences',
            'digitalPublications',
            'videos'
        ];

        // Set scope to only include sidebar items that can be related to
        $relatedSidebarItems = RelatedItem::where('browser_name', 'sidebar_items')
            ->where('related_id', $id)
            ->where('related_type', $modelName)
            ->whereIn('subject_type', $editorialTypes)
            ->get();

        foreach ($relatedSidebarItems as $item) {
            // Resolve the model class
            $modelClass = Relation::getMorphedModel($item->subject_type) ?? $item->subject_type;
            $itemId = $item->subject_id;

            if (class_exists($modelClass)) {
                $sidebarItem = app($modelClass)->find($itemId);

                if ($sidebarItem) {
                    $relatedItems[] = $sidebarItem;
                }
            }
        }

        // Filter out null items
        $relatedItems = array_filter($relatedItems);

        // Set types that should be weighted to the top
        $weightedTypes = ['article', 'highlight', 'experience'];

        // Compare related items by publish date, with weighted types at the top
        usort($relatedItems, function ($a, $b) use ($weightedTypes) {
            $aType = $a->subject_type;
            $bType = $b->subject_type;

            // If both are weighted or neither are weighted, sort by publish date
            $bothArePriority = in_array($aType, $weightedTypes) && in_array($bType, $weightedTypes);
            $neitherIsPriority = !in_array($aType, $weightedTypes) && !in_array($bType, $weightedTypes);

            if ($bothArePriority || $neitherIsPriority) {
                return $b->publish_start_date <=> $a->publish_start_date;
            }

            // If only one is weighted, sort it to the top
            if (in_array($aType, $weightedTypes)) {
                return -1;
            }

            return 1;
        });

        return $relatedItems;
    }
}
