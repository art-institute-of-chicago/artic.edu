<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\EducatorResource;

class EducatorResourceRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(EducatorResource $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            "title" => $item->title,
            "breadcrumb" => [],
            "blocks" => null,
            'featuredRelated' => [],
            'nav' => [],
            'page' => $item,
        ];
    }
}
