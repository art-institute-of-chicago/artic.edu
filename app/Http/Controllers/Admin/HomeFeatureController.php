<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class HomeFeatureController extends ModuleController
{
    protected $moduleName = 'homeFeatures';

    protected $indexOptions = [
        'permalink' => false,
    ];
}
