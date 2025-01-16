<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use App\Models\HomeFeature;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class HomeFeatureRepository extends ModuleRepository
{
    use HandleMedias, HandleBLocks, HandleApiBlocks, HandleFiles, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $browsers = [
        'articles' => [
            'routePrefix' => 'collection.articles_publications',
        ],
        'events' => [
            'routePrefix' => 'exhibitionsEvents',
        ],
        'highlights' => [
            'routePrefix' => 'collection',
        ],
    ];

    protected $apiBrowsers = [
        'exhibitions' => [
            'routePrefix' => 'exhibitionsEvents'
        ],
    ];

    public function __construct(HomeFeature $model)
    {
        $this->model = $model;
    }
}
