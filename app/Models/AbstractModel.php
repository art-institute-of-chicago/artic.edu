<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Behaviors\LintsAttributes;
use Aic\Hub\Foundation\Models\Concerns\HasByLastModScope;
use A17\Twill\Models\Model;

/**
 * This is a place for us to override default Twill model functionality.
 * Currently, it only affects bona-fide Models, not Slugs, Translations, Revisions, etc.
 */

class AbstractModel extends Model
{
    use LintsAttributes;
    use HasByLastModScope;

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key, $this->lintValue($value));
    }

    /**
     * Don't just check the `published` column! Also check
     * `publish_start_date` and `publish_end_date`. See
     * `scopeVisible` on `\A17\Twill\Models\Model`.
     */
    public function scopePublished($query): Builder
    {
        if (config('aic.is_preview_mode')) {
            return $query;
        }

        // scopeVisible checks for its fillable columns
        $query->visible();

        if ($this->isFillable('published')) {
            $query->wherePublished(true);
        }

        return $query;
    }

    public function scopeVisible($query): Builder
    {
        if (config('aic.is_preview_mode')) {
            return $query;
        }

        return parent::scopeVisible(...func_get_args());
    }

    public function getIsPublishedAttribute()
    {
        return static::published()->find($this->id) !== null;
    }

    public function getPreviewUrl($baseUrl)
    {
        // $baseUrl ends with /
        return config('app.url') . '/p/' . encrypt($baseUrl . $this->slug);
    }
}
