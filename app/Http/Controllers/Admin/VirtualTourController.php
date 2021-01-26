<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class VirtualTourController extends ModuleController
{
    protected $moduleName = 'virtualTours';
    protected $previewView = 'site.virtualTourDetail';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
    ];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('virtualTour') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/virtual-tours/' . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
