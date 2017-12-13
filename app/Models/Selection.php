<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;

class Selection extends Model
{
    use HasSlug, HasMedias;

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

    public $mediasParams = [
        'hero' => [
            'default' => '16/9',
            'square' => '1',
        ]
    ];

    public function artworks()
    {
        return $this->belongsToMany('App\Models\Artwork', 'artwork_selection')->withPivot('position')->orderBy('position');
    }

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection', 'selection_selection', 'selection_id', 'related_selection_id')->withPivot('position')->orderBy('position');
    }
}
