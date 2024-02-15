<?php

namespace App\Http\Controllers\Admin;

class LightboxController extends ModuleController
{
    protected $moduleName = 'lightboxes';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'lightboxStartDate' => [
            'title' => 'Start Date',
            'field' => 'lightboxStartDate',
            'present' => true,
            'sortKey' => 'lightbox_start_date',
            'sort' => true,
        ],
        'lightboxEndDate' => [
            'title' => 'End Date',
            'field' => 'lightboxEndDate',
            'present' => true,
            'sortKey' => 'lightbox_end_date',
            'sort' => true,
        ]
    ];
}
