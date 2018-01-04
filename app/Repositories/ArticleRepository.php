<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Article;

class ArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        // $this->updateOrderedBelongsTomany($object, $fields, 'articles');
        // $this->updateOrderedBelongsTomany($object, $fields, 'artists');
        // $this->updateOrderedBelongsTomany($object, $fields, 'exhibitions');
        // $this->updateOrderedBelongsTomany($object, $fields, 'selections');
        // $this->updateOrderedBelongsTomany($object, $fields, 'shopItems');

        $this->updateBrowser($object, $fields, 'exhibitions');
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'artists');
        $this->updateBrowser($object, $fields, 'selections');
        $this->updateBrowser($object, $fields, 'shopItems');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowser($object, 'exhibitions', 'whatson');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'whatson');
        $fields['browsers']['artists'] = $this->getFormFieldsForBrowser($object, 'artists', 'whatson');
        $fields['browsers']['selections'] = $this->getFormFieldsForBrowser($object, 'selections', 'whatson');
        $fields['browsers']['shopItems'] = $this->getFormFieldsForBrowser($object, 'shopItems', 'whatson');

        return $fields;
    }
}
