<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;

use App\Models\HomeArtist;
use App\Repositories\Behaviors\HandleApiRelations;

class HomeArtistRepository extends ModuleRepository
{
    use HandleMedias, HandleApiRelations;

    protected $apiBrowsers = [
        'artists' => [
            'routePrefix' => 'collection'
        ],
    ];

    public function __construct(HomeArtist $model)
    {
        $this->model = $model;
    }
}
