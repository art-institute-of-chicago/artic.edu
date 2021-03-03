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
use App\Repositories\Behaviors\HandleMagazine;
use App\Repositories\Behaviors\HandleAuthors;

class ArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleApiRelations, HandleApiBlocks, HandleBlocks, HandleMagazine, HandleFeaturedRelated, HandleAuthors {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $morphType = 'articles';

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateRelatedBrowser($object, $fields, 'sponsors');
        $this->updateMultiBrowserApiRelated($object, $fields, 'further_reading_items', [
            'articles' => false,
            'experiences' => false
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['sponsors'] = $this->getFormFieldsForRelatedBrowser($object, 'sponsors');
        $fields['browsers']['further_reading_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'further_reading_items', [], [
            'articles' => false,
            'experiences' => false
        ]);

        return $fields;
    }

    public function getArticleLayoutsList() {
        return collect($this->model::$articleLayouts);
    }

    public function getRelatedItems($item)
    {
        // Get items set specifically in the CMS
        $relatedItems = $item->getRelatedWithApiModels("further_reading_items", [], [
            'articles' => false,
            'experiences' => false
        ]);

        // Append with auto-fills
        $category_ids = $item->categories->pluck('id')->all();
        $relatedItems = $relatedItems->concat(\App\Models\Article::byCategories($category_ids)->published()->notUnlisted()->orderBy('date', 'desc')->take(5)->get());

        // Return the first four
        return $relatedItems->slice(0, 4)->values();
    }

    public function searchApi($string, $perPage = null)
    {
        $search  = Search::query()->search($string)->published()->resources(['articles']);

        $results = $search->getSearch($perPage);

        return $results;
    }

    public function getFurtherReadingTitle($item)
    {
        if ($item->is_in_magazine && $item->is_unlisted) {
            return 'Also in this Issue';
        }

        return 'Further Reading';
    }

    public function getFurtherReadingItems($item)
    {
        if ($item->is_in_magazine && $item->is_unlisted) {
            return $this->getAlsoInThisIssue($item);
        }

        return $this->getRelatedItems($item);
    }
}
