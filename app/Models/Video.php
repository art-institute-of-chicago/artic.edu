<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Facades\EmbedConverterFacade;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class Video extends AbstractModel
{
    use HasBlocks;
    use HasFiles;
    use HasMedias;
    use HasMediasEloquent;
    use HasRelated;
    use HasRevisions;
    use HasSlug;
    use HasFactory;
    use Transformable;

    protected $presenter = 'App\Presenters\Admin\VideoPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\VideoPresenter';

    protected $fillable = [
        'date',
        'description',
        'duration',
        'heading',
        'is_captioned',
        'is_listed',
        'is_short',
        'list_description',
        'meta_description',
        'meta_title',
        'privacy',
        'published',
        'search_tags',
        'thumbnail_url',
        'title',
        'title_display',
        'toggle_autorelated',
        'uploaded_at',
        'video_url',
        'youtube_id',
    ];

    protected $casts = [
        'date' => 'date',
        'is_captioned' => 'boolean',
        'is_listed' => 'boolean',
        'published' => 'boolean',
        'toggle_autorelated' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    public $attributes = [
        'is_listed' => false,
        'published' => false,
        'toggle_autorelated' => false,
    ];

    protected $appends = [
        'embed',
        'format',
        'video_url',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public $slugAttributes = [
        'title',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'video_category');
    }

    public function videoCategories()
    {
        return $this->belongsToMany(VideoCategory::class, 'video_video_category', 'video_id', 'video_category_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)
            ->withTimestamps()
            ->withPivot('position');
    }

    public function captions()
    {
        return $this->hasMany(Caption::class);
    }

    public function format(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => $attributes['is_short'] ? 'Short' : 'Video',
        );
    }

    public function videoUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($_, array $attributes) => $attributes['youtube_id'] ? "https://youtube.com/watch?v={$attributes['youtube_id']}" : null,
        );
    }

    public function scopeByCategories($query, $categories = null): Builder
    {
        if (empty($categories)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', is_array($categories) ? $categories : [$categories]);
        });
    }

    public function scopeByPlaylists($query, $playlistIds = []): Builder
    {
        return $query->whereHas('playlists', function ($query) use ($playlistIds) {
            $query->whereIn('playlist_id', $playlistIds);
        });
    }

    public function getEmbedAttribute()
    {
        return EmbedConverterFacade::convertUrl($this->video_url);
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
        return join('-', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        // Workaround for the CMS, should be moved away from the model
        return join([route('videos'), '/', $this->id, '-']);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('twill.collection.articlesPublications.videos.edit', $this->id);
    }

    public function getUrlAttribute()
    {
        return route('videos.show', ['id' => $this->id, 'slug' => $this->getSlug()], false);
    }

    public function getTypeAttribute()
    {
        return 'video';
    }

    protected static function booted(): void
    {
        static::addGlobalScope('available', function (Builder $query) {
            if (!App::environment('production')) {
                $query->where('privacy', '<>', 'private');
            }
        });
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
                'name' => 'date',
                'doc' => 'Date',
                'type' => 'date',
                'value' => function () {
                    return $this->date;
                },
            ],
            [
                'name' => 'video_url',
                'doc' => 'Video URL',
                'type' => 'text',
                'value' => function () {
                    return $this->video_url;
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
                    return url(route('articles.show', $this));
                },
            ],
            [
                'name' => 'heading',
                'doc' => 'heading',
                'type' => 'string',
                'value' => function () {
                    return $this->heading;
                },
            ],
            [
                'name' => 'copy',
                'doc' => 'Copy',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                },
            ],
            [
                'name' => 'related',
                'doc' => 'Related Content',
                'type' => 'array',
                'value' => function () {
                    return $this->transformRelated();
                },
            ],
        ];
    }
}
