<?php

namespace App\Models;

use PDO;
use Illuminate\Support\Facades\DB;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasMediasEloquent;

class DigitalPublication extends AbstractModel
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent, Transformable;

    protected $fillable = [
        'listing_description',
        'short_description',
        'title',
        'title_display',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    public $checkboxes = [
        'published',
        'active',
        'public',
    ];

    public $dates = [
        'publish_start_date',
        'publish_end_date',
    ];

    public $sections = [];

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

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('collection.publications.digital-publications'), '/', $this->id, '-']);
    }

    public function getUrlAttribute() {
        return route('collection.publications.digital-publications.show', $this->slug);
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    /**
     * Alphabetical sort by title [WEB-964]
     * @link https://stackoverflow.com/questions/3252577
     * @link https://stackoverflow.com/questions/47903727
     */
    public function scopeOrdered($query)
    {
        $driver = DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

        return $query->orderByRaw($driver === 'pgsql' ? (
            "regexp_replace(lower(title), '^(an?|the) (.*)$', '\\2, \\1')"
        ) : (
            "CASE
                WHEN title REGEXP '^(\"a|an|the|el|la\")[[:space:]]' = 1 THEN
                    TRIM(SUBSTR(title, INSTR(title, ' ')))
                ELSE title
            END ASC"
        ));
    }

    public function sections()
    {
        return $this->sections;
    }

    public function addSection($section)
    {
        return $this->sections[] = $section;
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'title',
                "doc" => "Title",
                "type" => "string",
                "value" => function() { return $this->title; }
            ],
            [
                "name" => 'web_url',
                "doc" => "Web URL",
                "type" => "string",
                "value" => function() { return url($this->url); }
            ],
            [
                "name" => 'slug',
                "doc" => "Slug",
                "type" => "string",
                "value" => function() { return $this->getSlug(); }
            ],
            [
                "name" => 'listing_description',
                "doc" => "Listing Description",
                "type" => "string",
                "value" => function() { return $this->listing_description; }
            ],
            [
                "name" => 'short_description',
                "doc" => "Short Description",
                "type" => "string",
                "value" => function() { return $this->short_description; }
            ],
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],
            [
                "name" => 'publish_start_date',
                "doc" => "Publish Start Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_start_date; }
            ],
            [
                "name" => 'publish_end_date',
                "doc" => "Publish End Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_end_date; }
            ],
            [
                "name" => 'content',
                "doc" => "Content",
                "type" => "text",
                "value" => function() { return $this->blocks; }
            ],
        ];
    }

}
