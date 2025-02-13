<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use App\Models\PageFeature;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class PageFeatureRepository extends ModuleRepository
{
    use HandleMedias, HandleBLocks, HandleApiBlocks, HandleFiles, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $browsers = [
        'articles' => [
            'routePrefix' => 'collection.articlesPublications',
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

    public function __construct(PageFeature $model)
    {
        $this->model = $model;
    }
}
