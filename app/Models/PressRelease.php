<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasUnlisted;
use Carbon\Carbon;
use DB;

class PressRelease extends AbstractModel
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent, Transformable, HasUnlisted;

    protected $fillable = [
        'short_description',
        'listing_description',
        'title',
        'title_display',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'migrated_node_id',
        'migrated_at',
        'meta_title',
        'meta_description',
        'is_unlisted',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'public', 'is_unlisted'];

    public $dates = ['publish_start_date', 'publish_end_date', 'migrated_at'];

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
        'banner' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 200 / 24,
                ],
            ],
        ],
    ];

    /**
     * A list of file roles
     */
    public $filesParams = ['attachment'];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join('/', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        return route('about.press.show', $this->id);
    }

    public function getSlugAttribute()
    {
        return route('about.press.show', $this);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.generic.pressReleases.edit', $this->id);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('publish_start_date', 'desc');
    }

    public function scopeCurrent($query)
    {
        return $query->whereNull('publish_start_date')
            ->orWhere('publish_start_date', '>', Carbon::parse('2011-12-31'));
    }

    public function scopeArchive($query)
    {
        return $query->where('publish_start_date', '<=', Carbon::parse('2011-12-31'));
    }

    public function getUrlAttribute()
    {
        return url(route('about.press.show', $this->id_slug));
    }

    public function scopeByYear($query, $year)
    {
        return $query->where(DB::raw('EXTRACT( YEAR FROM publish_start_date )'), $year);
    }

    public function scopeByMonth($query, $year)
    {
        return $query->where(DB::raw('EXTRACT( MONTH FROM publish_start_date )'), $year);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                }
            ],
            [
                'name' => 'web_url',
                'doc' => 'Web URL',
                'type' => 'string',
                'value' => function () {
                    return url($this->url);
                }
            ],
            [
                'name' => 'slug',
                'doc' => 'Slug',
                'type' => 'string',
                'value' => function () {
                    return $this->getSlug();
                }
            ],
            [
                'name' => 'listing_description',
                'doc' => 'Listing Description',
                'type' => 'string',
                'value' => function () {
                    return $this->listing_description;
                }
            ],
            [
                'name' => 'short_description',
                'doc' => 'Short Description',
                'type' => 'string',
                'value' => function () {
                    return $this->short_description;
                }
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                }
            ],
            [
                'name' => 'publish_start_date',
                'doc' => 'Publish Start Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_start_date;
                }
            ],
            [
                'name' => 'publish_end_date',
                'doc' => 'Publish End Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_end_date;
                }
            ],
            [
                'name' => 'is_unlisted',
                'doc' => 'Whether the press release is unlisted',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_unlisted;
                }
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                }
            ],
        ];
    }

    /**
     * For global search! Puts date above title.
     */
    public function getSubtypeAttribute()
    {
        if ($this->publish_start_date) {
            return $this->publish_start_date->format('F j, Y');
        }
    }
}
