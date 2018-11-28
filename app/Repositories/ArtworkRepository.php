<?php

namespace App\Repositories;

use App\Models\Artwork;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['sidebarExhibitions']);
        $this->updateBrowserApiRelated($object, $fields, ['sidebarDigitalLabels']);
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'sidebarArticle');
        $this->updateBrowser($object, $fields, 'videos');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['sidebarDigitalLabels'] = $this->getFormFieldsForBrowserApi($object, 'sidebarDigitalLabels', 'App\Models\Api\DigitalLabel', 'exhibitions_events');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['sidebarArticle'] = $this->getFormFieldsForBrowser($object, 'sidebarArticle', 'collection.articles_publications', 'title', 'articles');

        return $fields;
    }

}
