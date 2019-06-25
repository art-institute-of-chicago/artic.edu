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
        return $this->relatedItems->map(function ($item) { return $this->_transformRelatedItem($item); })
            ->union($this->relatedTos->map(function ($item) { return $this->_transformRelatedItem($item, 'subject'); }))
            ->all();
    }

    static function _transformRelatedItem($item, $prefix = 'related') {
        $ret = collect($item->getAttributes())->only([$prefix .'_id', $prefix .'_type'])->all();
        $return = [];
        $return['id'] = $ret[$prefix .'_id'];
        $return['type'] = $ret[$prefix .'_type'];
        $return['title'] = $item->$prefix->title;
        return $return;
    }
}
