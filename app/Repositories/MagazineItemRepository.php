<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\MagazineItem;

class MagazineItemRepository extends ModuleRepository
{
    use HandleMedias, HandleRevisions;

    public function __construct(MagazineItem $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'selections', 'position', 'Selection');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'experiences', 'position', 'Interactive Feature');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $this->updateRelatedBrowser($object, $fields, 'articles');
        $this->updateRelatedBrowser($object, $fields, 'selections');
        $this->updateRelatedBrowser($object, $fields, 'experiences');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['articles'] = $this->getFormFieldsForRelatedBrowser($object, 'articles', 'collection.articles_publications', 'title', 'articles');
        $fields['browsers']['selections'] = $this->getFormFieldsForRelatedBrowser($object, 'selections', 'collection', 'title', 'selections');
        $fields['browsers']['experiences'] = $this->getFormFieldsForRelatedBrowser($object, 'experiences', 'collection', 'title', 'experiences');

        return $fields;
    }

}
