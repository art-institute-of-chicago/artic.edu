<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\PageCategoryRepository;

class GenericPageController extends BaseController
{
    protected function setUpController(): void
    {
        $this->enableReorder();
        $this->setModuleName('genericPages');
        $this->setPreviewView('site.genericPage.show');
    }

    /**
     * Exposed as public for sitemap:generate command.
     */
    protected function indexData($request)
    {
        $pagesList = $this->repository->withDepth()->defaultOrder()->get()->filter(function ($page) {
            return $page->depth < 3;
        })->pluck('title', 'id');

        $pagesList = $pagesList->prepend('None', '');

        return [
            'nested' => true,
            'nestedDepth' => 10,
            'pages' => $pagesList,
        ];
    }

    private function getParents($exceptPage = null)
    {
        return $this->repository->whereNotIn('id', is_null($exceptPage) ? [] : [$exceptPage])->withDepth()->defaultOrder()->orderBy('position')->get()->filter(function ($page) {
            return $page->depth < 3;
        })->values();
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('genericPage') ?? request('id'));
        $ancestors = $item->ancestors()->defaultOrder()->get();

        $baseUrl = config('app.url') . '/';

        foreach ($ancestors as $ancestor) {
            $baseUrl = $baseUrl . $ancestor->slug . '/';
        }

        $breadcrumb = $ancestors->map(function ($parentPage) {
            return [
                'label' => $parentPage->title,
                'url' => $this->getModuleRoute($parentPage->id, 'edit'),
            ];
        })->toArray();

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'parents' => $this->getParents($item->id)->map(function ($parent) {
                return [
                    'id' => $parent->id,
                    'name' => $parent->title,
                    'edit' => $this->getModuleRoute($parent->id, 'edit'),
                ];
            }),
            'breadcrumb' => (empty($breadcrumb) ? null : $breadcrumb),
            'baseUrl' => $baseUrl,

            'categoriesList' => app(PageCategoryRepository::class)->listAll('name'),
        ];
    }

    protected function transformIndexItems($items): \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
    {
        // If we're in the browser, don't transform the items
        if (property_exists($items, 'path')) {
            return $items;
        }
        return $items->toTree();
    }

    protected function indexItemData($item)
    {
        return $item->children ? [
            'children' => $this->getIndexTableData($item->children),
        ] : [];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
