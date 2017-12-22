<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

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
        ],
    ];

    protected $indexWith = [];

    protected $formWith = ['revisions', 'siteTags', 'shopItems'];

    protected $filters = [];

    protected $formWithCount = ['revisions'];
    protected $defaultOrders = ['date' => 'desc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
        ];
    }

}
