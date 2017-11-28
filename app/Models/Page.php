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
        1 => 'Exhibitions and Events',
        2 => 'Art and Ideas'
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
        'art_intro'
    ];

    public $slugAttributes = [
        'title',
    ];

    // public function featuredWorks()
    // {
    //     return $this->belongsToMany('App\Models\Work', 'page_work_work')->withPivot('position')->orderBy('position');
    // }

    public function homeExhibitions()
    {
        return $this->belongsToMany('App\Models\Exhibition', 'page_home_exhibition')->withPivot('position')->orderBy('position');
    }
}
