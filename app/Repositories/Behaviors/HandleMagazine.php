<?php

namespace App\Repositories\Behaviors;

use App\Models\MagazineItem;
use App\Models\MagazineIssue;

trait HandleMagazine
{
    private $magazineItems = [];

    public function getMagazineItem($item)
    {
        return $magazineItems[$item->id] ?? $magazineItems[$item->id] = MagazineItem::query()
            ->where('magazinable_type', $this->morphType)
            ->where('magazinable_id', $item->id)
            ->first();
    }

    /**
     * Be sure to add `protected $morphType = '___';` to your repository.
     */
    public function getAlsoInThisIssue($item)
    {
        $magItem = $this->getMagazineItem($item);

        if ($magItem) {
            $position = $magItem->position;
            $magIssue = $magItem->magazineIssue;
        } else {
            $position = 0;
            $magIssue = MagazineIssue::whereHas('relatedItems', function ($query) use ($item) {
                $query->where('browser_name', 'welcome_note');
                $query->where('related_id', $item->id);
            })->first();

            if (!$magIssue) {
                return null;
            }
        }

        $items = $magIssue->magazineItems()->where('position', '>', $position)->get();
        if ($items->count() < 4) {
            $items = $items->concat($magIssue->magazineItems()->where('position', '<', $position)->get());
        }

        $alsoIn = $items->map(function ($item, $key) {
            return $item->magazinable;
        });

        return $alsoIn->filter()->slice(0, 4)->values();
    }

    protected function isInMagazine($item)
    {
        if ($item->is_in_magazine) {
            return true;
        }

        if ($this->getMagazineItem($item) ?? false) {
            return true;
        }

        return false;
    }
}
