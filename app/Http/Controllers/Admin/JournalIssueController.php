<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class JournalIssueController extends ModuleController
{
    protected $moduleName = 'journalIssues';

    protected $permalinkBase = 'journal/issue/';

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
            'title' => 'Date',
            'edit_link' => true,
            'sort' => true,
            'field' => 'date',
            'present' => true,
        ],
        'issue_number' => [
            'title' => 'Issue No.',
            'edit_link' => true,
            'sort' => true,
            'field' => 'issueNumber',
            'present' => true,
        ],
    ];

    protected $defaultOrders = ['position' => 'asc'];

    protected function formData($request)
    {
        $item = $this->repository->getById(request('journalIssue') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/' .$this->permalinkBase . $item->issue_number . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}
