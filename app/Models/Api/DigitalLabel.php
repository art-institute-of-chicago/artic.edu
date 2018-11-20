<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use Illuminate\Support\Carbon;
use App\Models\Api\Asset;

class DigitalLabel extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/digital-labels',
        'resource' => '/api/v1/digital-labels/{id}',
        'search' => '/api/v1/digital-labels/search',
    ];

    // protected $appends = ['date'];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\DigitalLabel';

    protected $presenter = 'App\Presenters\Admin\DigitalLabelPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalLabelPresenter';

    // Fields used when performing a search so we avoid a double call retrieving the complete entities
    const SEARCH_FIELDS = ['id', 'title', 'is_boosted', 'thumbnail', 'exhibition_id', 'type', 'copy_text', 'image_url', 'is_published', 'source_created_at', 'source_modified_at', 'last_updated_source', 'last_updated'];

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    // public function getTypeAttribute()
    // {
    //     return 'digitalLabel';
    // }

    // public function getIsClosedAttribute()
    // {
    //     if (empty($this->aic_end_at)) {
    //         if (empty($this->aic_start_at)) {
    //             return true;
    //         } else {
    //             return $this->dateStart->year < 2010;
    //         }
    //     } else {
    //         return Carbon::now()->gt($this->dateEnd->endOfDay());
    //     }
    // }

    public function getIdSlugAttribute()
    {
        return join(array_filter([$this->id, $this->getSlug()]), '/');
    }

    public function getTitleSlugAttribute()
    {
        return getUtf8Slug($this->title);
    }

    // public function getAicDateStartAttribute()
    // {
    //     if (!empty($this->aic_start_at)) {
    //         return new Carbon($this->aic_start_at);
    //     }

    // }

    // public function getDateStartAttribute()
    // {
    //     if (!empty($this->aic_start_at)) {
    //         return new Carbon($this->aic_start_at);
    //     }

    // }

    // public function getDateEndAttribute()
    // {
    //     if (!empty($this->aic_end_at)) {
    //         return new Carbon($this->aic_end_at);
    //     }

    // }

    // public function getIsClosingSoonAttribute()
    // {
    //     if (!empty($this->dateEnd)) {
    //         return Carbon::now()->between($this->dateEnd->endOfDay()->subWeeks(2), $this->dateEnd->endOfDay());
    //     }

    // }

    // public function getIsNowOpenAttribute()
    // {
    //     if (!empty($this->dateStart) && !empty($this->dateEnd)) {
    //         return Carbon::now()->between($this->dateStart->startOfDay(), $this->dateStart->startOfDay()->addWeeks(2));
    //     }

    // }

    // // See exhibitionType() in ExhibitionPresenter
    // public function getIsOngoingAttribute()
    // {
    //     if (empty($this->aic_end_at)) {
    //         if (isset($this->aic_start_at)) {
    //             if ($this->dateStart->year > 2010) {
    //                 return Carbon::now()->gt($this->dateStart->startOfDay());
    //             }
    //         }
    //     }

    //     return false;
    // }

    public function getListDescriptionAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->copy_text)) {
            return $this->copy_text;
        }

        return null;
    }

    // public function getDescriptionAttribute($value)
    // {
    //     $desc = nl2br($value);
    //     return '<p>' . preg_replace('#(<br>[\r\n\s]+){2}#', "</p>\n\n<p>", $desc) . '</p>';
    // }

    // public function scopeOrderBy($query, $field, $direction = 'asc')
    // {
    //     $params = [
    //         "sort" => [
    //             "{$field}.keyword" => $direction
    //         ]
    //     ];

    //     return $query->rawQuery($params);
    // }

    // public function scopeOrderByDate($query, $direction = 'asc')
    // {
    //     $params = [
    //         "sort" => [
    //             'aic_start_at' => $direction
    //         ]
    //     ];

    //     return $query->rawQuery($params);
    // }

    // public function artworks()
    // {
    //     return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    // }

    // public function artists()
    // {
    //     return $this->hasMany(\App\Models\Api\Artist::class, 'artist_ids');
    // }

    // public function historyImages()
    // {
    //     return $this->hasMany(\App\Models\Api\Asset::class, 'alt_image_ids');
    // }

    // public function historyDocuments()
    // {
    //     return $this->hasMany(\App\Models\Api\Asset::class, 'document_ids');
    // }
}
