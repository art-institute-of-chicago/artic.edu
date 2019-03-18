<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\DigitalLabel;
use App\Repositories\Behaviors\HandleApiBlocks;
use Artisan;

class DigitalLabelRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

    function afterSave($object, $fields)
    {
        Artisan::call('update:content-bundles', [
            'datahub_id' => $object->datahub_id,
        ]);

        parent::afterSave($object, $fields);
    }

}
