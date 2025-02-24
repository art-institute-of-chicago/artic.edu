<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\SiteTagRepository;
use App\Repositories\CategoryRepository;

class HighlightController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setupController();
        $this->eagerLoadFormRelationCounts(['siteTags']);
        $this->enableReorder();
        $this->enableShowImage();
        $this->setModuleName('highlights');
        $this->setPreviewView('site.articleDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('artworksCount')
        );

        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('highlight') ?? request('id'));
        $baseUrl = config('app.url') . '/highlights/' . request('highlight') . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'baseUrl' => $baseUrl,
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'highlightTypeList' => $this->repository->getHighlightTypeList(),
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
