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

    protected $relatedBrowsers = [
        'sponsors'
    ];

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateMultiBrowserApiRelated($object, $fields, 'further_reading_items', [
            'articles' => false,
            'experiences' => false,
            'highlights' => false,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['further_reading_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'further_reading_items', [], [
            'articles' => false,
            'experiences' => false,
            'highlights' => false,
        ]);

        return $fields;
    }

    public function getArticleLayoutsList()
    {
        return collect($this->model::$articleLayouts);
    }

    public function searchApi($string, $perPage = null)
    {
        $search = Search::query()->search($string)->published()->notUnlisted()->resources(['articles']);

        $results = $search->getSearch($perPage);

        return $results;
    }

    public function getFurtherReadingTitle($item)
    {
        if ($this->isInMagazine($item) && $item->is_unlisted) {
            return 'Also in this Issue';
        }

        return 'Further Reading';
    }

    public function getFurtherReadingItems($item)
    {
        $relatedItems = $this->getCustomRelateditems($item);

        if ($relatedItems->count() > 3) {
            return $relatedItems;
        }

        if ($item->is_in_magazine && $item->is_unlisted) {
            $relatedIds = $relatedItems->pluck('id')->all();
            $autoRelated = $this->getAlsoInThisIssue($item) ?? collect([]);
            $autoRelated = $autoRelated->filter(function ($item) use ($relatedIds) {
                return !in_array($item->id, $relatedIds);
            });
        } else {
            $categoryIds = $item->categories->pluck('id')->all();
            $autoRelated = Article::query()
                ->byCategories($categoryIds)
                ->published()
                ->notUnlisted()
                ->orderBy('date', 'desc')
                ->take(5)
                ->get();
        }

        $relatedItems = $relatedItems->concat($autoRelated);

        return $relatedItems->slice(0, 4)->values();
    }

    protected function getCustomRelateditems($item)
    {
        return $item
            ->getRelated('further_reading_items')
            ->filter(function ($item) {
                return $item->is_published === true;
            });
    }
}
