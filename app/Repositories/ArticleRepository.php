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
use App\Repositories\Behaviors\HandleFeaturedRelated;

class ArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleApiRelations, HandleApiBlocks, HandleBlocks, HandleFeaturedRelated {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateMultiBrowserApiRelated($object, $fields, 'further_reading_items', [
            'articles' => false,
            'interactiveFeatures.experiences' => false
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['further_reading_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'further_reading_items', [], [
            'articles' => false,
            'interactiveFeatures.experiences' => false
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
