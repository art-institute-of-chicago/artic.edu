<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\PressRelease;
use App\Models\Api\Search;

class PressReleaseRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    protected $browsers = [
        'sponsors' => [
            'routePrefix' => 'exhibitions_events',
        ],
    ];

    public function __construct(PressRelease $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
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
            'nav' => null,
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
