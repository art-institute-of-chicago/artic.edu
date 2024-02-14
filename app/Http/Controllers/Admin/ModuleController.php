<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ModuleController extends BaseModuleController
{
    protected function getAutoRelated($item)
    {
        $autoRelated = collect($item->related($item))->unique('id')->filter();

        $featuredRelated = $this->getFeatureRelated($item);
        $featuredRelatedIds = $featuredRelated->pluck('id');

        // Remove featured related items from auto related items
        if ($featuredRelatedIds->isNotEmpty()) {
            $autoRelated = $autoRelated->reject(function ($relatedItem) use ($featuredRelatedIds) {
                return ($relatedItem !== null && ($featuredRelatedIds->contains($relatedItem->id) || $featuredRelatedIds->contains($relatedItem->datahub_id)));
            });
        }

        return $autoRelated;
    }

    protected function getFeatureRelated($item)
    {
        return collect($item->getFeaturedRelated())->pluck('item');
    }
}
