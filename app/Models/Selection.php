<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Selection extends Model
{
    use HasSlug;

    protected $presenterAdmin = 'App\Presenters\Admin\SelectionPresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'short_copy',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public function artworks()
    {
        return $this->belongsToMany('App\Models\Artwork', 'artwork_selection')->withPivot('position')->orderBy('position');
    }
}
