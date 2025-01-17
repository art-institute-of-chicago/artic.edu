<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;

class VideoController extends ModuleController
{
    protected $moduleName = 'videos';
    protected $previewView = 'site.videoDetail';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
    ];

    /**
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /**
     * Relations to eager load for the form view
     */
    protected $formWith = [];

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
        $item = $this->repository->getById(request('video') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/videos/' . $item->id . '-';

        return [
            'baseUrl' => $baseUrl,
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
