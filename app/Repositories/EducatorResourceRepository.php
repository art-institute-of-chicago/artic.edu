<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Models\EducatorResource;
use App\Models\Api\Search;

class EducatorResourceRepository extends ModuleRepository
{
    use HandleTranslations, HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(EducatorResource $model)
    {
        $this->model = $model;
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->categories()->sync($fields['categories'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getShowData($item, $slug = null, $previewPage = null): array
    {
        return [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => [],
            'blocks' => null,
            'nav' => [],
            'page' => $item,
        ];
    }

    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        $search = Search::query()->search($string)->published()->resources(['educator-resources']);

        $results = $search->getSearch($perPage, $columns, null, $page);

        return $results;
    }
}
