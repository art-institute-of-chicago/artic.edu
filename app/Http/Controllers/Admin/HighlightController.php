<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class HighlightController extends ModuleController
{
    protected $moduleName = 'highlights';
    protected $previewView = 'site.articleDetail';

    protected $indexOptions = [
        'permalink' => true,
        'reorder' => true,
    ];

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
        'artworksCount' => [
            'title' => 'Artworks count',
            'edit_link' => true,
            'field' => 'artworksCount',
            'present' => true,
        ],
    ];

    /**
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /**
     * Relations to eager load for the form view
     */
    protected $formWith = ['siteTags'];

    /**
     * Filters mapping ('filterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (filterNameList)
     */
    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/highlights/' . request('highlight') . '/';

        return [
            'baseUrl' => $baseUrl,
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'highlightTypeList' => $this->repository->getHighlightTypeList(),
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
