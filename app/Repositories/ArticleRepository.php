<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Article;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class ArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['artworks', 'exhibitions', 'sidebarExhibitions']);
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'selections');
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'sidebarArticle');
        $this->updateBrowser($object, $fields, 'videos');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'collection');
        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');
        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['selections'] = $this->getFormFieldsForBrowser($object, 'selections', 'collection');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['sidebarArticle'] = $this->getFormFieldsForBrowser($object, 'sidebarArticle', 'collection.articles_publications', 'title', 'articles');

        return $fields;
    }

    public function getArticleLayoutsList() {
        return collect($this->model::$articleLayouts);
    }
}
