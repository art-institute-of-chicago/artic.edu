<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\LandingPageRepository;
use App\Models\LandingPageType;
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
    ];

    protected $indexWith = [];

    protected $defaultOrders = [];

    protected $previewView = 'site.landingPageDetail';

    protected function indexData($request)
    {
        $types = LandingPageType::all()->pluck('page_type', 'id')->toArray();
        $typesOptions = $this->getTypesOptions($types);

        return [
            'types' => $types,
            'typesOptions' => $typesOptions,
        ];
    }

    protected function formData($request)
    {
        $types = LandingPageType::all()->pluck('page_type', 'id')->toArray();
        $typesOptions = $this->getTypesOptions($types);

        $baseUrl = '//' . config('app.url') . '/';

        return [
            'types' => $types,
            'typesOptions' => $typesOptions,
            'baseUrl' => $baseUrl,
        ];
    }

    public function getTypesOptions($types)
    {
        $list = [];

        foreach ($types as $value => $label) {
            $list[] = ['value' => $value, 'label' => $label];
        }

        return $list;
    }
    protected function getRoutePrefix()
    {
        return null;
    }
}
