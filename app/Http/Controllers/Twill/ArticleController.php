<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\CategoryRepository;

class ArticleController extends \App\Http\Controllers\Twill\ModuleController
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
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
            'articleLayoutsList' => $this->repository->getArticleLayoutsList(),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function getBrowserData(array $prependScope = []): array
    {
        if ($this->request->has('is_unlisted')) {
            $prependScope['is_unlisted'] = $this->request->get('is_unlisted');
        }

        if ($this->request->has('published')) {
            $prependScope['published'] = $this->request->get('published');
        }

        return parent::getBrowserData($prependScope);
    }
}
