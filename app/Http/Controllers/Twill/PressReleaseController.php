<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;

class PressReleaseController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('pressReleases');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('presentPublishStartDate')
                ->title('Publish Date')
                ->sortable()
                ->sortKey('publish_start_date')
        );

        return $columns;
    }

    protected function formData($request)
    {
        $baseUrl = config('app.url') . '/press/press-releases/' . request('pressRelease') . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
