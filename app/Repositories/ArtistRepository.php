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
        $this->updateMultiBrowserApiRelated($object, $fields, 'related_items', [
            'articles' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
            'digitalLabels' => false,
            'exhibitions' => true,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['related_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'related_items', [
            'digitalLabels' => [
                'apiModel' => 'App\Models\Api\DigitalLabel',
                'routePrefix' => 'collection',
                'moduleName' => 'digitalLabels',
            ],
            'digitalPublications' => [
                'apiModel' => 'App\Models\DigitalPublication',
                'routePrefix' => 'articles_publications',
                'moduleName' => 'digitalPublications',
            ],
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'articles' => false,
            'digitalPublications' => false,
            'printedPublication' => false,
            'educatorResource' => false,
            'digitalLabels' => false,
            'exhibitions' => true,
        ]);

        return $fields;
    }

}
