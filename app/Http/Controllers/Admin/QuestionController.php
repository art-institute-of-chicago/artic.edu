<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class QuestionController extends ModuleController
{
    protected $moduleName = 'questions';

    protected $titleColumnKey = 'question';

    protected $indexColumns = [
        'question' => [
            'title' => 'Question',
            'edit_link' => true,
            'field' => 'question',
        ],
        'answer' => [
            'title' => 'Answer',
            'edit_link' => true,
            'field' => 'answer',
        ],
    ];

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [];

    protected $defaultOrders = ['position' => 'asc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

}
