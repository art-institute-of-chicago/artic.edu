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

    public function sidebarExhibitions()
    {
        return $this->apiElements()->where('relation', 'sidebarExhibitions');
    }

    public function sidebarEvent()
    {
        return $this->belongsToMany('App\Models\Event', 'artwork_event')->withPivot('position')->orderBy('position');
    }

    public function sidebarArticle()
    {
        return $this->belongsToMany('App\Models\Article', 'article_artwork')->withPivot('position')->orderBy('position');
    }

    public function sidebarExperiences()
    {
        return $this->belongsToMany('App\Models\Experience', 'artwork_experience')->withPivot('position')->orderBy('position');
    }

    public function getTrackingSlugAttribute()
    {
        return $this->title;
    }

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video')->withPivot('position')->orderBy('position');
    }

    public function getSlugAttribute()
    {
        return ['en' => getUtf8Slug($this->title)];
    }

}
