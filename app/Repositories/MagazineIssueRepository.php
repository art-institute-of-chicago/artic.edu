<?php

namespace App\Repositories;

use App\Models\MagazineIssue;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;

class MagazineIssueRepository extends ModuleRepository
{
    use HandleSlugs, HandleBlocks, HandleMedias, HandleRepeaters, HandleRevisions;

    public function __construct(MagazineIssue $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'magazineItems', 'position', 'MagazineItem');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $this->updateRepeater($object, $fields, 'magazineItems', 'MagazineItem');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'magazineItems', 'MagazineItem');

        return $fields;
    }
}

