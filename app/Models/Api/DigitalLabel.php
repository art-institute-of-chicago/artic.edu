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
    const SEARCH_FIELDS = ['id', 'title', 'is_boosted', 'thumbnail', 'exhibition_id', 'type', 'copy_text', 'image_url', 'is_published', 'source_created_at', 'source_modified_at', 'last_updated_source', 'last_updated', 'api_model'];

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join(array_filter([$this->id, $this->getSlug()]), '/');
    }

    public function getTitleSlugAttribute()
    {
        return getUtf8Slug($this->title);
    }

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
}
