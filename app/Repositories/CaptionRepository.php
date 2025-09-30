<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Caption;

class CaptionRepository extends ModuleRepository
{
    use HandleFiles;
    use HandleTranslations;

    protected $browsers = [
        'video' => [
            'routePrefix' => 'collection.articlesPublications',
        ],
    ];

    public function __construct(Caption $model)
    {
        $this->model = $model;
    }
}
