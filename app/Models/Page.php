<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
// use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    use HasSlug, HasRevisions;

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('type', function (Builder $builder) {
    //         $builder->orderBy('type');
    //     });
    // }

    public static $types = [
        0 => 'Home',
        1 => 'ExhibitionsEvents and Events',
        2 => 'Art and Ideas',
        3 => 'Visit'
    ];

    protected $fillable = [
        'published',
        'position',
        'type',
        'title',

        // Homepage
        'home_intro',

        // Exhibition
        'exhibition_intro',

        // Art and Ideas
        'art_intro',

        // Visit
        'visit_intro'
    ];

    public $slugAttributes = [
        'title',
    ];

    public function homeExhibitions()
    {
        return $this->belongsToMany('App\Models\Exhibition', 'page_home_exhibition')->withPivot('position')->orderBy('position');
    }

    public function homeEvents()
    {
        return $this->belongsToMany('App\Models\Event', 'page_home_event')->withPivot('position')->orderBy('position');
    }
}
