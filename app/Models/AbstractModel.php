<?php

namespace App\Models;

use App\Models\Behaviors\LintsAttributes;
use A17\Twill\Models\Model;

/**
 * This is a place for us to override default Twill model functionality.
 * Currently, it only affects bona-fide Models, not Slugs, Translations, Revisions, etc.
 */

class AbstractModel extends Model
{
    use LintsAttributes;

    /**
     * Don't just check the `published` column! Also check
     * `publish_start_date` and `publish_end_date`. See
     * `scopeVisible` on `\A17\Twill\Models\Model`.
     */
    public function scopePublished($query)
    {
        return $query->visible()->wherePublished(true);
    }

    public function getIsPublishedAttribute()
    {
        return self::published()->find($this->id) != null;
    }
}
