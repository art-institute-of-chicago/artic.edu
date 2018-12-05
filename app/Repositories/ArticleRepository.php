<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\Article;
use App\Models\Api\Search;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class ArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleApiRelations, HandleApiBlocks, HandleBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['sidebarExhibitions']);
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'sidebarArticle');
        $this->updateBrowser($object, $fields, 'videos');
        $this->updateMultiBrowserApiRelated($object, $fields, 'further_reading_items', [
            'articles' => false,
            'digitalLabels' => true
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['sidebarArticle'] = $this->getFormFieldsForBrowser($object, 'sidebarArticle', 'collection.articles_publications', 'title', 'articles');
        $fields['browsers']['further_reading_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'further_reading_items', [
            'digitalLabels' => [
                'apiModel' => 'App\Models\Api\DigitalLabel',
                'routePrefix' => 'collection',
                'moduleName' => 'digitalLabels',
            ],   
        ], [ 
            'articles' => false,
            'digitalLabels' => true
        ]);

        return $fields;
    }

    public function getArticleLayoutsList() {
        return collect($this->model::$articleLayouts);
    }

    public function searchApi($string, $perPage = null)
    {
        $search  = Search::query()->search($string)->published()->resources(['articles']);

        $results = $search->getSearch($perPage);

        return $results;
    }
}
