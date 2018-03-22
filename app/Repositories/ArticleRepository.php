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

        $this->updateBrowserApiRelated($object, $fields, ['artworks', 'exhibitions']);
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'selections');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'collection');
        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['selections'] = $this->getFormFieldsForBrowser($object, 'selections', 'collection');

        return $fields;
    }

    public function getArticleLayoutsList() {
        return collect($this->model::$articleLayouts);
    }

    public function getFormFieldsHandleSlugs($object, $fields)
    {
        unset($fields['slugs']);

        if ($object->slugs != null) {
            foreach ($object->slugs as $slug) {
                if ($slug->active || $object->slugs->where('locale', $slug->locale)->where('active', true)->count() === 0) {
                    $fields['translations']['slug'][$slug->locale] = $object->idSlug;
                }
            }
        }

        return $fields;
    }
}
