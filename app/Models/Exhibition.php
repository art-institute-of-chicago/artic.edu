<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;

class Exhibition extends Model
{
    use HasRevisions, HasSlug;

    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'header_copy',
        'start_date',
        'end_date',
        'short_copy',
        'datahub_id'
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public $dates = ['start_date', 'end_date'];

    // fill this in if you use the HasMedias traits
    // public $mediasParams = [];

    // fill this in if you use the HasFiles traits
    // public $filesParams = [];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }
}
