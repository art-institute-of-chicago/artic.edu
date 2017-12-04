<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;

class Event extends Model
{
    use HasSlug, HasRevisions;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'price',
        'datahub_id',
        'admission',
        'start_date',
        'end_date',
        'recurring',
        'recurring_start_date',
        'recurring_end_date',
        'recurring_days',
        'location',
        'latitude',
        'longitude',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['recurring'];

    // fill this in if you use the HasMedias traits
    // public $mediasParams = [];

    // fill this in if you use the HasFiles traits
    // public $filesParams = [];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_event', 'event_id', 'related_event_id')->withPivot('position')->orderBy('position');
    }
}
