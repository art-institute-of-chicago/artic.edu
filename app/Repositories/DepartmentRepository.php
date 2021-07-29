<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Department;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\HandleApiRelations;

class DepartmentRepository extends BaseApiRepository
{
    use HandleMedias, HandleApiRelations;

    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['customRelatedArtworks']);

        $this->updateMultiBrowserApiRelated($object, $fields, 'related_items', [
            'articles' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
            'videos' => false,
            'exhibitions' => true,
            'experiences' => false,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['customRelatedArtworks'] = $this->getFormFieldsForBrowserApi($object, 'customRelatedArtworks', 'App\Models\Api\Artwork', 'collection', 'title', 'artworks');

        $fields['browsers']['related_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'related_items', [
            'experiences' => [
                'apiModel' => 'App\Models\Experience',
                'routePrefix' => 'collection.interactive_features',
                'moduleName' => 'experiences',
            ],
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'articles' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
            'videos' => false,
            'exhibitions' => true,
            'experiences' => false,
        ]);

        return $fields;
    }

}
