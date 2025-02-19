<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Http\Controllers\LandingPagesController;
use App\Models\LandingPage;
use App\Repositories\LandingPageRepository;

class LandingPageController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('landingPages') ;
        $this->setPreviewView('site.landingPageDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('type')
        );

        return $columns;
    }

    /**
     * Dynamically set the view prefix to include the landing page type.
     */
    public function edit(TwillModelContract|int $id, $submoduleId = null): mixed
    {
        $landingPage = $this->repository->getById($id);
        $prefix = str($landingPage->type)->camel();
        $this->viewPrefix = "twill.$this->moduleName.$prefix";
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
