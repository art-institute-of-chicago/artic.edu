<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class DigitalCatalogController extends ModuleController
{
    protected $moduleName = 'digitalCatalogs';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/publications/digital-catalogs/";
        return [
            'baseUrl' => $baseUrl
        ];
    }

}
