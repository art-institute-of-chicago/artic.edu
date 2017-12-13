<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;

class Article extends Model
{
    use HasSlug, HasRevisions, HasMedias;

    protected $presenterAdmin = 'App\Presenters\Admin\ArticlePresenter';

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

    public $mediasParams = [
        'hero' => [
            'default' => '16/9',
            'square' => '1',
        ]
    ];

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

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }
}
