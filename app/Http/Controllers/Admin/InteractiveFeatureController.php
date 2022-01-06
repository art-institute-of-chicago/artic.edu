<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\InteractiveFeature;

class InteractiveFeatureController extends ModuleController
{
    protected $moduleName = 'interactiveFeatures';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'updated_at' => [
            'title' => 'Updated At',
            'field' => 'updatedDate',
            'present' => true,
        ],
    ];

    protected $formWith = ['revisions'];

    protected $defaultOrders = ['title' => 'desc'];

    protected $indexOptions = [
        'permalink' => false,
    ];
    protected $filters = [];

    protected function getIndexTableMainFilters($items, $scopes = [])
    {
        $statusFilters = parent::getIndexTableMainFilters($items, $scopes);
        array_push($statusFilters, [
            'name' => 'Archived',
            'slug' => 'archived',
            'number' => InteractiveFeature::archived()->count(),
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
