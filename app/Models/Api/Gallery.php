<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Models\Api\Search;

class Gallery extends BaseApiModel
{
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

    public function artworks($perPage = 20)
    {
        return Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search')
            ->byGalleryIds($this->id)
            ->aggregationClassifications(55)
            ->getSearch($perPage);
    }

}
