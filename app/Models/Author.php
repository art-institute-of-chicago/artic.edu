<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use App\Models\Behaviors\HasMediasEloquent;

class Author extends AbstractModel
{
    use HasSlug;
    use HasMedias;
    use HasRevisions;
    use HasMediasEloquent;

    protected $fillable = [
        'published',
        'title',
        'description',
        'list_description'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    protected $presenter = 'App\Presenters\Admin\AuthorPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\AuthorPresenter';

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => '1',
                ],
            ]
        ],
    ];

    public function articles()
    {
        return $this->morphedByMany('App\Models\Article', 'authorable');
    }

    public function highlights()
    {
        return $this->morphedByMany('App\Models\Highlight', 'authorable');
    }

    public function experiences()
    {
        return $this->morphedByMany('App\Models\Experience', 'authorable');
    }

    public function scopeOrdered($query): Builder
    {
        if ($this->isFillable('title')) {
            $query->orderByRaw("reverse(split_part(reverse(title), ' ', 1))")->get();
        }

        return $query;
    }
}
