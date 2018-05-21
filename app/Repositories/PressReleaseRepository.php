<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
// use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\PressRelease;

class PressReleaseRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;
    // HandleTranslations,

    public function __construct(PressRelease $model)
    {
        $this->model = $model;
    }

    // Show data, moved here to allow preview
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
