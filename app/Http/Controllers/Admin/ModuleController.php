<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ModuleController extends BaseModuleController
{
    protected function previewData($item)
    {
        return [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
        ];
    }

    protected function getAutoRelated($item)
    {
        if (!method_exists($item, 'related')) {
            return [];
        }

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
        if (!method_exists($item, 'getFeaturedRelated')) {
            return [];
        }

        return collect($item->getFeaturedRelated())->pluck('item');
    }
}
