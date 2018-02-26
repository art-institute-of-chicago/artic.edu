<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use App\Repositories\Api\BaseApiRepository;
use App\Models\Artist;

class ArtistRepository extends BaseApiRepository
{
    use HandleSlugs;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowserApiRelated($object, $fields, ['featuredArtworks']);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields['browsers']['featuredArtworks'] = $this->getFormFieldsForBrowserApi($object, 'featuredArtworks', 'App\Models\Api\Artwork', 'whatson');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'whatson');
        return $fields;
    }

}
