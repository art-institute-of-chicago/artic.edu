<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\IssueRepository;

class IssueArticleController extends ModuleController
{
    protected $moduleName = 'issues.articles';
    protected $modelName = 'IssueArticle';

    protected $permalinkBase = 'journal/articles/';

    protected function getParentModuleForeignKey()
    {
        return 'issue_id';
    }

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

    protected function indexData($request)
    {
        $issue = app(IssueRepository::class)->getById(request('issue'));
        return [
            'breadcrumb' => [
                [
                    'label' => 'Issues',
                    'url' => moduleRoute('issues', 'collection', 'index'),
                ],
                [
                    'label' => $issue->title,
                    'url' => moduleRoute('issues', 'collection', 'edit', $issue->id),
                ],
                [
                    'label' => 'Articles',
                ],

            ],
        ];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('article') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/' .$this->permalinkBase . $item->id . '/';

        $issue = app(IssueRepository::class)->getById(request('issue'));
        return [
            'baseUrl' => $baseUrl,
            'breadcrumb' => [
                [
                    'label' => 'Issues',
                    'url' => moduleRoute('issues', 'collection', 'index'),
                ],
                [
                    'label' => $issue->title,
                    'url' => moduleRoute('issues', 'collection', 'edit', $issue->id),
                ],
                [
                    'label' => 'Articles',
                    'url' => moduleRoute('issues.articles', 'collection', 'index', $request->route('issue')),
                ],
                [
                    'label' => $issue->title,
                ],
            ],
        ];
    }

}
