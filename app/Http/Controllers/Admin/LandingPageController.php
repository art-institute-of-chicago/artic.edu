<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\LandingPage;
use Session;

class LandingPageController extends ModuleController
{
    protected $moduleName = 'landingPages';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
        ],
    ];

    protected $indexWith = [];

    protected $defaultOrders = [];

    protected $previewView = 'site.landingPageDetail';

    protected function indexData($request)
    {
        $types = collect(LandingPage::TYPES);

        return [
            'defaultType' => $types->search(LandingPage::DEFAULT_TYPE),
            'types' => $types->sort(),
        ];
    }

    protected function formData($request)
    {
        $types = collect(LandingPage::TYPES);
        $baseUrl = '//' . config('app.url') . '/';

        return [
            'defaultType' => $types->search(LandingPage::DEFAULT_TYPE),
            'homeType' => $types->search('Home'),
            'researchAndResourcesType' => $types->search('Research and Resources'),
            'visitType' => $types->search('Visit'),
            'types' => $types->sort(),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function getRoutePrefix()
    {
        return null;
    }
}
