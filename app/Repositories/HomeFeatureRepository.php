<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use App\Models\HomeFeature;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

use App\Repositories\Api\BaseApiRepository;

class HomeFeatureRepository extends ModuleRepository
{
    use  HandleMedias, HandleBLocks, HandleApiBlocks, HandleFiles, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $browsers = [
        'articles' => [
            'routePrefix' => 'collection.articles_publications',
        ],
        'events' => [
            'routePrefix' => 'exhibitions_events',
        ],
        'selections' => [
            'routePrefix' => 'collection',
        ],
    ];

    public function __construct(HomeFeature $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['exhibitions']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');

        return $fields;
    }

}
