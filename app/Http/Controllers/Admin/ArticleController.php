<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\CategoryRepository;

class ArticleController extends ModuleController
{
    protected $moduleName = 'articles';

    protected $indexColumns = [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'square',
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
    ];

    protected $indexWith = [];

    protected $formWith = ['revisions', 'categories'];

    protected $filters = [];

    protected $formWithCount = ['revisions'];
    protected $defaultOrders = ['date' => 'desc'];

    protected $previewView = 'site.articleDetail';

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
            'articleLayoutsList' => $this->repository->getArticleLayoutsList(),
        ];
    }
}
