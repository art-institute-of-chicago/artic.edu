<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\CategoryRepository;

class ArticleController extends BaseController
{
    protected function setUpController(): void
    {
        $this->eagerLoadFormRelationCounts(['revisions']);
        $this->eagerLoadFormRelations(['revisions', 'categories']);
        $this->enableShowImage();
        $this->setModuleName('articles');
        $this->setPreviewView('site.articleDetail');
        parent::setUpController();
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('date')
                ->sortable()
        );
        $columns->add(
            Relation::make()
                ->field('title')
                ->title('Author')
                ->relation('authors')
        );

        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('article') ?? request('id'));
        $baseUrl = config('app.url') . '/articles/' . $item->id . '/';

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
