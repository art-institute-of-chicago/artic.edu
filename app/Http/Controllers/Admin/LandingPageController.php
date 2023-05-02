<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\LandingPageRepository;
use Session;

class LandingPageController extends ModuleController
{
    const MISSING_CMS_PAGE_MESSAGE = "CMS home page doesn't exist, make sure to migrate the database and seed it first (php artisan migrate & php artisan db:seed)";

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
        return [];
    }

    protected function formData($request)
    {
        $isVisit = stripos($request->path(), 'visit') !== false ? true : false;

        return [
            'permalink' => false,
            'publish' => false,
            'editableTitle' => $isVisit,
            'translate' => $isVisit,
        ];
    }

    protected function getRoutePrefix()
    {
        return null;
    }

    protected function moduleHas($behavior)
    {
        return $behavior === 'revisions' ? false : parent::moduleHas($behavior);
    }
}
