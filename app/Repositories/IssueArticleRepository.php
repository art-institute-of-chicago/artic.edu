<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Jobs\GeneratePdf;
use App\Models\IssueArticle;
use App\Models\Api\Search;

class IssueArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleRevisions, HandleBlocks, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(IssueArticle $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'authors');
        GeneratePdf::dispatch($object);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields['browsers']['authors'] = $this->getFormFieldsForBrowser($object, 'authors', 'collection');
        return $fields;
    }

    public function searchApi($string, $perPage = null)
    {
        $search  = Search::query()->search($string)->published()->resources(['issue-articles']);

        $results = $search->getSearch($perPage);

        return $results;
    }
}
