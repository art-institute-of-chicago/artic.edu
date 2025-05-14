<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Presenters\Admin\IlluminatedLinkPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IlluminatedLink extends AbstractModel
{
    use HasFactory;
    use HasMedias;
    use HasMediasEloquent;
    use HasRevisions;

    protected $presenterAdmin = IlluminatedLinkPresenter::class;
    protected $presenter = IlluminatedLinkPresenter::class;


    protected $fillable = [
        'description',
        'published',
        'title',
        'url',
    ];

    protected $appends = [
        'url_without_slug',
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

    public function getUrl()
    {
        return $this->url;
    }

    public function getUrlWithoutSlugAttribute()
    {
        return $this->getUrl();
    }
}
