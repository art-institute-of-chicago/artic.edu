<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class ScholarlyJournalController extends ModuleController
{
    protected $moduleName = 'scholarlyJournals';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/publications/scholarly-journals/";
        return [
            'baseUrl' => $baseUrl
        ];
    }
}
