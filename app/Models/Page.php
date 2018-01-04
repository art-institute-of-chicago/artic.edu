<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Admission as Admission;

// use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    use HasSlug, HasRevisions, HasMedias;

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
        2 => 'Art and Ideas',
        3 => 'Visit',
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
        'visit_intro',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function homeExhibitions()
    {
        return $this->belongsToMany('App\Models\Exhibition', 'page_home_exhibition')->withPivot('position')->orderBy('position');
    }

    public function homeEvents()
    {
        return $this->belongsToMany('App\Models\Event', 'page_home_event')->withPivot('position')->orderBy('position');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class)->orderBy('position');
    }

    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('position');
    }
}
