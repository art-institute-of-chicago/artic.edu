<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Api\Artwork;
use App\Models\Api\Search;
use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasUnlisted;

class Highlight extends AbstractModel
{
    use HasSlug, HasRevisions, HasPosition, HasMedias, HasMediasEloquent, HasBlocks, Transformable, HasRelated, HasApiRelations, HasFeaturedRelated, HasUnlisted, HasAuthors;

    protected $presenterAdmin = 'App\Presenters\Admin\HighlightPresenter';
    protected $presenter = 'App\Presenters\Admin\HighlightPresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'title_display',
        'short_copy',
        'hero_caption',
        'meta_title',
        'meta_description',
        'publish_start_date',
        'publish_end_date',
        'highlight_type',
        'is_unlisted',
        'is_in_magazine',
        'author_display'
    ];

    public $slugAttributes = [
        'title',
    ];

    const NORMAL = 0;
    const AUDIO_TOUR = 1;

    public static $highlightTypes = [
        self::NORMAL => 'Normal',
        self::AUDIO_TOUR => 'Audio tour',
    ];

    /**
     * Those fields get auto set to null if not submited
     */
    public $nullable = [];

    /**
     * Those fields get auto set to false if not submited
     */
    public $checkboxes = [
        'published',
        'is_unlisted',
        'is_in_magazine',
    ];

    public $dates = [
        'publish_start_date',
        'publish_end_date',
    ];

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
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function getListDescriptionAttribute()
    {
        return $this->short_copy;
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

    public function getTypeAttribute()
    {
        return 'highlight';
    }

    public function getSubtypeAttribute()
    {
        return 'Highlights'; // for pinboard and listings
    }

    public function getHeaderTypeAttribute()
    {
        return 'hero';
    }

    public function getIntroAttribute()
    {
        return $this->short_copy;
    }

    public function getTrackingTitleAttribute()
    {
        return $this->title;
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.collection.highlights.edit', $this->id);
    }

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function artworks($perPage = 20)
    {
        return Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search')
            ->byIds($this->getArtworkIds()->toArray())
            ->aggregationClassifications(50)
            ->getSearch($perPage);
    }

    public function getArtworkIds()
    {
        $artwork_ids = collect([]);
        foreach ($this->blocks as $block) {
            if (in_array($block->type, ['artwork', 'artworks'])) {
                if (isset($block->content['browsers'])) {
                    if (isset($block->content['browsers']['artworks'])) {
                        $ids = $block->content['browsers']['artworks'];
                        foreach ($ids as $id) {
                            $artwork_ids->push($id);
                        }
                    }
                }
            }
        }

        return $artwork_ids;
    }

    public function getArtworkImages($count = 5)
    {
        $list = collect([]);
        $artwork_ids = $this->getArtworkIds();

        if ($artwork_ids->isNotEmpty()) {
            $artworks = Artwork::query()->ids($artwork_ids->toArray())->get();
            foreach ($artworks as $artwork) {
                if ($artwork->imageFront()) {
                    $list[] = $artwork->imageFront();
                }

                if ($list->count() >= $count) {
                    break;
                }
            }
        }

        return $list;
    }

    public function getImagesAttribute()
    {
        return $this->getArtworkImages();
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
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
                'doc' => 'Whether the highlight is unlisted',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_unlisted;
                }
            ],
            [
                'name' => 'updated_at',
                'doc' => 'Updated',
                'type' => 'date',
                'value' => function () {
                    return $this->updated_at;
                },
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                },
            ],
            [
                'name' => 'short_copy',
                'doc' => 'Short Copy',
                'type' => 'text',
                'value' => function () {
                    return $this->short_copy;
                },
            ],
            [
                'name' => 'slug',
                'doc' => 'slug',
                'type' => 'string',
                'value' => function () {
                    return $this->slug;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'web_url',
                'type' => 'string',
                'value' => function () {
                    return url(route('highlights.show', $this));
                },
            ],
        ];
    }
}
