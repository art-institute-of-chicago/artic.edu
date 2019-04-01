<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\DigitalLabel;
use App\Repositories\Api\DigitalLabelRepository;
use App\Repositories\SiteTagRepository;

class DigitalLabelController extends ModuleController
{
    protected $moduleName = 'digitalLabels';
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
        'experiences' => [
            'title' => 'Experiences',
            'nested' => 'experiences',
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

    protected function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);
        array_push($statusFilters, [
            'name' => 'Archived',
            'slug' => 'archived',
            'number' => DigitalLabel::archived()->count(),
        ]);
        return $statusFilters;
    }

    protected function getIndexItems($scopes = [], $forcePagination = false)
    {
        $requestFilters = $this->getRequestFilters();
        if (array_key_exists('status', $requestFilters) && $requestFilters['status'] == 'archived') {
            $scopes = $scopes + ['archived' => true];
        } else {
            $scopes = $scopes + ['unarchived' => true];
        }
        return parent::getIndexItems($scopes, $forcePagination);
    }

}
