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

}
