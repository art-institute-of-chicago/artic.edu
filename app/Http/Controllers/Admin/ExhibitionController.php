<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\SiteTagRepository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class ExhibitionController extends BaseApiController
{
    protected $moduleName = 'exhibitions';
    protected $hasAugmentedModel = true;
    protected $previewView = 'site.exhibitionDetail';

    protected $indexOptions = [
        'publish' => true,
        'bulkEdit' => false,
        'create' => false,
        'permalink' => true,
    ];

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'optional' => false,
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
        ],
        'date' => [
            'title' => 'Dates',
            'field' => 'date',
            'present' => true,
            'optional' => false,
            'sort' => true,
            'sortKey' => 'aic_start_at',
        ],
    ];

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags'];

    protected $defaultOrders;

    protected $filters = [];

    public function __construct(Application $app, Request $request)
    {
        parent::__construct(...func_get_args());

        if ($this->getRequestFilters()['search'] ?? false) {
            $this->defaultOrders = ['_score' => 'desc'];
        } else {
            $this->defaultOrders = ['aic_start_at' => 'desc'];
        }

    }

    protected function orderScope()
    {
        // Use the default order scope from Twill.
        // Added this as an exception on exhibitions because it's the only API listing that
        // sorting has been implemented. See `scopeOrderBy` on Models\Api\Exhibition
        return ModuleController::orderScope();
    }

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('exhibition') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/exhibitions/' . $item->datahub_id . '/';

        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'exhibitionTypesList' => $this->repository->getExhibitionTypesList(),
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(ExhibitionRepository::class);
        $apiItem = $apiRepo->getById($item->datahub_id);

        // Force the augmented model
        $apiItem->setAugmentedModel($item);

        return $apiRepo->getShowData($apiItem);
    }

}
