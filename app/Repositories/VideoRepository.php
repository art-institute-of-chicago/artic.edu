<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Video;

class VideoRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'item' => $item,
            'relatedVideos' => collect([])
        ];
    }

    public function getRelatedVideos($item)
    {
        return $this->model::published()->limit(4)->whereNotIn('id', [$item->id])->get();
    }


}
