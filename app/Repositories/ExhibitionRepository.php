<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Models\Exhibition;
use App\Repositories\Api\BaseApiRepository;
use Illuminate\Support\Collection;

class ExhibitionRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers as getApiBlockBrowsers;
    }
    use HandleFeaturedRelated {
        HandleApiBlocks::getBlockBrowsers as getFeatureRelatedBlockBrowsers;
    }

    protected $browsers = [
        'sponsors' => [
            'routePrefix' => 'exhibitionsEvents',
        ],
        'events' => [
            'routePrefix' => 'exhibitionsEvents',
        ]
    ];

    protected $apiBrowsers = [
        'exhibitions' => [
            'routePrefix' => 'exhibitionsEvents'
        ],
        'shopItems',
        'waitTimes',
    ];

    protected array $repeaters = [
        'offers'
    ];

    public function getBlockBrowsers($block)
    {
        return array_merge($this->getApiBlockBrowsers($block), $this->getFeatureRelatedBlockBrowsers($block));
    }

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    public function hydrate(TwillModelContract $object, array $fields): TwillModelContract
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');

        return parent::hydrate($object, $fields);
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getExhibitionTypesList(): Collection
    {
        return collect($this->model::$exhibitionTypes);
    }

    public function getExhibitionStatusesList(): Collection
    {
        return collect($this->model::$exhibitionStatuses);
    }
}
