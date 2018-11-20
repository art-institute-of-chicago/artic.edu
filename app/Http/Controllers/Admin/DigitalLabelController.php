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
        'title' => [
            'title' => 'Name',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'field' => 'id',
        ],
    ];

    protected $formWith = ['revisions', 'siteTags'];

    protected $defaultOrders = ['title' => 'desc'];

    protected $filters = [];

    protected function orderScope()
    {
        // Use the default order scope from Twill.
        // Added this as an exception on exhibitions because it's the only API listing that
        // sorting has been implemented. See the scope on Models\Api\Exhibition
        return ModuleController::orderScope();
    }

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
