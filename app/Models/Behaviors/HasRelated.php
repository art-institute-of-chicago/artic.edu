<?php

namespace App\Models\Behaviors;

use A17\Twill\Models\RelatedItem;
use A17\Twill\Models\Behaviors\HasRelated as BaseHasRelated;

trait HasRelated
{
    use BaseHasRelated;

    public function relatedTos()
    {
        return $this->morphMany(RelatedItem::class, 'related')->where('browser_name', 'related_items');
    }

    public function transformRelated()
    {
        return $this->relatedItems->map(function ($item) {
            return $this->transformRelatedItem($item, 'related');
        })
            ->union($this->relatedTos->map(function ($item) {
                return $this->transformRelatedItem($item, 'subject');
            }))
            ->filter()
            ->all();
    }

    private function transformRelatedItem($item, $prefix)
    {
        // WEB-1753: Fix this trait to work with `api_relatables`
        if ($item->{$prefix . '_type'} === 'exhibitions') {
            return;
        }

        return [
            'id' => $item->{$prefix . '_id'},
            'type' => $item->{$prefix . '_type'},
            'title' => $item->{$prefix}->title,
        ];
    }
}
