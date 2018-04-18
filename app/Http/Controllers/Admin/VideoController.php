<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\VideoRepository;

class VideoController extends ModuleController
{
    protected $moduleName = 'videos';
    protected $previewView = 'site.videoDetail';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true
        ],
    ];

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(VideoRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }

}
