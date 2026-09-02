<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\AdCampaign;
use App\Repositories\Behaviors\HandleApiRelations;

class AdCampaignRepository extends ModuleRepository
{
    use HandleApiRelations;
    use HandleMedias;
    use HandleRevisions;

    protected $apiBrowsers = [
        'artists' => [
            'routePrefix' => 'collection'
        ],
        'artworks' => [
            'routePrefix' => 'collection'
        ],
    ];

    public function __construct(AdCampaign $model)
    {
        $this->model = $model;
    }
}
