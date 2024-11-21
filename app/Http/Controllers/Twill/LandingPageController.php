<?php

namespace App\Http\Controllers\Twill;

use App\Http\Controllers\LandingPagesController;
use App\Models\LandingPage;
use App\Repositories\LandingPageRepository;

class LandingPageController extends \App\Http\Controllers\Twill\ModuleController
{
    protected $moduleName = 'landingPages';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
        ],
    ];

    protected $indexWith = [];

    protected $defaultOrders = [];

    protected $previewView = 'site.landingPageDetail';

    /**
     * Dynamically set the view prefix to include the landing page type.
     */
    public function edit(\A17\Twill\Models\Contracts\TwillModelContract|int $id, $submoduleId = null): mixed
    {
        $landingPage = $this->repository->getById($id);
        $prefix = str($landingPage->type)->camel();
        $this->viewPrefix = "admin.$this->moduleName.$prefix";
        return parent::edit($id, $submoduleId);
    }

    protected function indexData($request)
    {
        $types = collect(LandingPage::TYPES);

        return [
            'defaultType' => $types->search(LandingPage::DEFAULT_TYPE),
            'types' => $types->sort(),
        ];
    }

    protected function formData($request)
    {
        $types = collect(LandingPage::TYPES);
        $baseUrl = '//' . config('app.url') . '/';

        return [
            'defaultType' => $types->search(LandingPage::DEFAULT_TYPE),
            'types' => $types->sort(),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        $repository = app(LandingPageRepository::class);
        $controller = new LandingPagesController($repository);
        return $controller->viewData($item);
    }
}
