<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class PageFeatureController extends ModuleController
{
    protected $moduleName = 'pageFeatures';

    protected $indexOptions = [
        'permalink' => false,
    ];
}
