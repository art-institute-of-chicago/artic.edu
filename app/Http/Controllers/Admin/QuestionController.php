<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class QuestionController extends ModuleController
{
    protected $moduleName = 'questions';

    protected $titleColumnKey = 'question';

    protected $indexOptions = [
        'reorder' => true,
        'editInModal' => true,
    ];

    protected $indexColumns = [
        'question' => [
            'title' => 'Question',
            'field' => 'question',
        ],
        'answer' => [
            'title' => 'Answer',
            'field' => 'answer',
        ],
    ];
}
