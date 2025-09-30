<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Caption;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VideoRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    protected $browsers = [
        'captions' => [
            'model' => Caption::class,
            'moduleName' => 'videos.captions',
            'routePrefix' => 'collection.articlesPublications',
        ],
        'playlists' => [
            'routePrefix' => 'collection.articlesPublications',
        ],
    ];

    protected $relatedBrowsers = [
        'related_videos' => [
            'relation' => 'related_videos'
        ],
    ];

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function order($query, array $orders = []): Builder
    {
        // Default sort by uploaded_at instead of created_at.
        $orders['uploaded_at'] ??= 'desc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
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
