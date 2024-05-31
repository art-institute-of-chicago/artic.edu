<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Enums\DigitalPublicationArticleType;
use App\Jobs\GeneratePdf;
use App\Models\DigitalPublicationArticle;
use App\Models\Api\Search;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleAuthors;

class DigitalPublicationArticleRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleRevisions, HandleBlocks, HandleApiBlocks, HandleAuthors {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(DigitalPublicationArticle $model)
    {
        $this->model = $model;
    }

    public function getTypes()
    {
        return collect(DigitalPublicationArticleType::cases())
            ->mapWithKeys(fn ($type) => [$type->value => $type->name]);
    }

    public function afterSave($object, $fields)
    {
        parent::afterSave($object, $fields);
        GeneratePdf::dispatch($object);
    }

    public function searchApi($string, $perPage = null)
    {
        $search = Search::query()->search($string)->published()->resources(['digital-publication-articles']);
        $results = $search->getSearch($perPage);

        return $results;
    }
}
