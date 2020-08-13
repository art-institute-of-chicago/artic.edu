<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;

use App\Models\HomeArtist;
use App\Repositories\Behaviors\HandleApiRelations;

class HomeArtistRepository extends ModuleRepository
{
    use HandleMedias, HandleApiRelations;

    public function __construct(HomeArtist $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['artists']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['artists'] = $this->getFormFieldsForBrowserApi($object, 'artists', 'App\Models\Api\Artist', 'collection', 'title', 'artists');

        return $fields;
    }
}
