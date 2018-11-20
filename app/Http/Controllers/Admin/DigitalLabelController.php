<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\SiteTagRepository;

class DigitalLabelController extends BaseApiController
{
    protected $moduleName = 'digitalLabels';
    protected $hasAugmentedModel = true;
    protected $previewView = 'site.digitalLabelDetail';

    protected $indexOptions = [
        'publish' => false,
        'bulkEdit' => false,
        'create' => false,
        'permalink' => true,
    ];

    protected $indexColumns = [
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'field' => 'id',
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
    ];

    protected $formWith = ['revisions'];

    protected $defaultOrders = ['title' => 'desc'];

    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalLabel') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/digital-labels/' . $item->datahub_id . '/';

        return [
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(DigitalLabelRepository::class);
        $apiItem = $apiRepo->getById($item->datahub_id);

        // Force the augmented model
        $apiItem->setAugmentedModel($item);

        return $apiRepo->getShowData($apiItem);
    }

}
