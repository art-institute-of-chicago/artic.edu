<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;
use App\Repositories\Api\ExhibitionRepository;
use App\Models\Api\Exhibition;

class ExhibitionController extends BaseApiController
{
    protected $moduleName = 'exhibitions';
    protected $hasAugmentedModel = true;
    protected $previewView = 'site.exhibitionDetail';

    protected $indexOptions = [
        'publish' => false,
        'bulkEdit' => false,
        'create' => false,
        'permalink' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
        ],
        'date' => [
            'title' => 'Dates',
            'field' => 'date',
            'present' => true,
            'optional' => false,
        ],
    ];

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags'];

    protected $defaultOrders = ['title' => 'desc'];

    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'exhibitionTypesList' => $this->repository->getExhibitionTypesList(),
            'editableTitle' => false,
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(ExhibitionRepository::class);
        $apiItem = $apiRepo->getById($item->datahub_id);

        // Force the augmented model
        $apiItem->setAugmentedModel($item);

        return $apiRepo->getShowData($apiItem);
    }

}
