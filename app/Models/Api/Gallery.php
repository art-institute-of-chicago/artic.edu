<?php

namespace App\Models\Api;

use A17\Twill\Models\Behaviors\HasPresenter;
use App\Libraries\Api\Models\BaseApiModel;

class Gallery extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/galleries',
        'resource' => '/api/v1/galleries/{id}',
        'search' => '/api/v1/galleries/search',
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Gallery';

    protected $presenter = 'App\Presenters\Admin\GalleryPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GalleryPresenter';

    public function getTypeAttribute()
    {
        return 'gallery';
    }

}
