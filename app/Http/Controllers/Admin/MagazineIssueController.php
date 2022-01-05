<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class MagazineIssueController extends ModuleController
{
    protected $moduleName = 'magazineIssues';

    protected $permalinkBase = 'magazine/issues/';

    protected $indexColumns = [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'date' => [
            'title' => 'Publish Date',
            'edit_link' => true,
            'sort' => true,
            'field' => 'publish_start_date',
            'present' => true,
        ],
    ];

    protected $defaultOrders = [
        'publish_start_date' => 'desc',
    ];

    protected function formData($request)
    {
        $item = $this->repository->getById(request('magazineIssue') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/' . $this->permalinkBase . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}
