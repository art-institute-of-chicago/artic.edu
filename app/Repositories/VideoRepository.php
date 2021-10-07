<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Video;

class VideoRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    protected $relatedBrowsers = [
        'related_videos' => [
            'relation' => 'related_videos'
        ],
    ];

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'item' => $item,
            'relatedVideos' => $this->getRelatedVideos($item),
        ];
    }

    public function getRelatedVideos($item)
    {
        // Filter collection after database query
        $customRelatedVideos = $item->getRelated('related_videos')->where('published', true);

        if (!$customRelatedVideos->isEmpty()) {
            return $customRelatedVideos;
        }

        return $this->model::published()->orderBy('date', 'desc')->whereNotIn('id', [$item->id])->limit(4)->get();
    }
}
