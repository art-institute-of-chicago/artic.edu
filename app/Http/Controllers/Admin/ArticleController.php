<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
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
        'author' => [
            'title' => 'Author',
            'edit_link' => true,
            'sort' => true,
            'field' => 'author',
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
        $item = $this->repository->getById(request('article') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/articles/' . $item->id . '/';

        return [
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
            'articleLayoutsList' => $this->repository->getArticleLayoutsList(),
            'baseUrl' => $baseUrl,
        ];
    }

    public function getBrowserData($prependScope = [])
    {
        if ($this->request->has('is_unlisted')) {
            $prependScope['is_unlisted'] = $this->request->get('is_unlisted');
        }

        return parent::getBrowserData($prependScope);
    }
}
