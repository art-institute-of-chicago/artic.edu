<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Artwork extends Model
{
    use HasSlug;

    protected $presenterAdmin = 'App\Presenters\Admin\ArtworkPresenter';

    protected $fillable = [
        'title',
        'subtitle',
        'copy',
        'datahub_id'
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection', 'artwork_selection');
    }

}
