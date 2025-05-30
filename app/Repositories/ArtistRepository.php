<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Artist;
use App\Repositories\Api\BaseApiRepository;

class ArtistRepository extends BaseApiRepository
{
    use HandleSlugs;
    use HandleMedias;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $this->updateMultiBrowserApiRelated($object, $fields, 'related_items', [
            'articles' => false,
            'digitalPublications' => false,
            'printedPublications' => false,
            'educatorResources' => false,
            'videos' => false,
            'exhibitions' => true,
            'experiences' => false,
        ]);

        $this->updateMultiBrowserApiRelated($object, $fields, 'hidden_related_items', [
            'exhibitions' => true,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['related_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'related_items', [
            'experiences' => [
                'apiModel' => 'App\Models\Experience',
                'routePrefix' => 'collection.interactiveFeatures',
                'moduleName' => 'experiences',
            ],
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitionsEvents',
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

        $fields['browsers']['hidden_related_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'hidden_related_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitionsEvents',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'exhibitions' => true,
        ]);

        return $fields;
    }
}
