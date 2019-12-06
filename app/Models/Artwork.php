<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;

use Illuminate\Support\Str;

class Artwork extends AbstractModel
{
    use HasApiModel, HasApiRelations, HasFeaturedRelated;

    protected $apiModel = 'App\Models\Api\Artwork';

    protected $fillable = [
        'datahub_id',
        'meta_title',
        'meta_description',
    ];

    public function getFullTitleAttribute()
    {
        return $this->title;
    }

    public function getTrackingSlugAttribute()
    {
        return $this->title;
    }

    public function getSlugAttribute()
    {
        return ['en' => getUtf8Slug($this->title)];
    }

}
