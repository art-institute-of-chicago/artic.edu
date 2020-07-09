<?php

namespace App\Repositories\Behaviors;

use App\Models\MagazineItem;

trait HandleMagazine
{
    /**
     * Be sure to add `protected $morphType = '___';` to your repository.
     */
    public function getAlsoInThisIssue($item)
    {
        $magItem = MagazineItem::where('magazinable_type', $this->morphType)->where('magazinable_id', $item->id)->first();

        if (!$magItem) {
            return null;
        }
        $position = $magItem->position;
        $magIssue = $magItem->magazineIssue;

        $items = $magIssue->magazineItems()->where('position', '>', $position)->get();
        if ($items->count() < 4) {
            $items = $items->concat($magIssue->magazineItems()->where('position', '<', $position)->get());
        }

        $alsoIn = $items->map(function ($item, $key) {
            return $item->magazinable;
        });

        return $alsoIn->filter()->slice(0, 4)->values();
    }
}
