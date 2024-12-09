<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Video;
use Illuminate\Support\Collection;

class VideoRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    protected $relatedBrowsers = [
        'related_videos' => [
            'relation' => 'related_videos'
        ],
    ];

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function getShowData($item, $slug = null, $previewPage = null): array
    {
        return [
            'item' => $item,
            'relatedVideos' => $this->getRelatedVideos($item),
        ];
    }

    public function getRelatedVideos($item): Collection
    {
        // Filter collection after database query
        $customRelatedVideos = $item->getRelated('related_videos')->where('published', true);

        if (!$customRelatedVideos->isEmpty()) {
            return $customRelatedVideos;
        }

        return $this->model::published()->orderBy('date', 'desc')->whereNotIn('id', [$item->id])->limit(4)->get();
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->categories()->sync($fields['categories'] ?? []);

        parent::afterSave($object, $fields);
    }
}
