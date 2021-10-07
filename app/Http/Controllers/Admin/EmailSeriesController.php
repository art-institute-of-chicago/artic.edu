<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class EmailSeriesController extends ModuleController
{
    protected $moduleName = 'emailSeries';

    protected $indexOptions = [
        'reorder' => true,
    ];
}
