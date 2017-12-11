<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;

class Article extends Model
{
    use HasSlug, HasRevisions;

    protected $fillable = [
        'published',
        'content',
        'title',
        'date',
        'copy'
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public $dates = ['date'];

    // fill this in if you use the HasMedias traits
    // public $mediasParams = [];

    // fill this in if you use the HasFiles traits
    // public $filesParams = [];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function exhibitions()
    {
        return $this->belongsToMany('App\Models\Exhibition', 'article_exhibition')->withPivot('position')->orderBy('position');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist', 'article_artist')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }
}
