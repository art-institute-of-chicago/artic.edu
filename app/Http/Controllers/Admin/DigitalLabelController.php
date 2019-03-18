<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\SiteTagRepository;

class DigitalLabelController extends ModuleController
{
    protected $moduleName = 'digitalLabels';
    protected $hasAugmentedModel = true;
    protected $previewView = 'site.digitalLabelDetail';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'updated_at' => [
            'title' => 'Updated At',
            'field' => 'updated_at',
            'sort' => true,
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
        $baseUrl = '//' . config('app.url') . '/interactive-features/' . $item->datahub_id . '/';

        return [
            'editableTitle' => true,
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
