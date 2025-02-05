<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\PressRelease;
use App\Models\Api\Search;
use Illuminate\Database\Eloquent\Builder;

class PressReleaseRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    protected $browsers = [
        'sponsors' => [
            'routePrefix' => 'exhibitionsEvents',
        ],
    ];

    public function __construct(PressRelease $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        $orders['publish_start_date'] ??= 'desc';
        unset($orders['created_at']);

        return parent::order($query, $orders);
    }

    public function hydrate(TwillModelContract $object, array $fields): TwillModelContract
    {
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');

        return parent::hydrate($object, $fields);
    }

    /**
     * Show data, moved here to allow preview
     */
    public function getShowData($item, $slug = null, $previewPage = null)
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
        $search = Search::query()->search($string)->notUnlisted()->published()->resources(['press-releases']);

        $results = $search->getSearch($perPage, $columns, null, $page);

        return $results;
    }
}
