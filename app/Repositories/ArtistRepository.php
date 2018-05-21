<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Artist;
use App\Repositories\Api\BaseApiRepository;

class ArtistRepository extends BaseApiRepository
{
    use HandleSlugs, HandleMedias;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'articles');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        return $fields;
    }

}
