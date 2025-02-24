<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;

class DigitalPublicationController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->setModuleName('digitalPublications');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('is_dsc_stub')
                ->title('Is DSC stub?')
                ->sortable()
        );
        $columns->add(
            NestedData::make()
                ->field('articles')
        );

        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalPublication') ?? request('id'));
        $baseUrl = config('app.url') . '/digital-publications/' . $item->id . '/';
        $heroBackgroundColors = collect(config('aic.branding.digital_publications.colors'))
            ->mapWithKeys(fn ($hexColor) => [$hexColor => $hexColor]);

        return [
            'baseUrl' => $baseUrl,
            'heroBackgroundColors' => $heroBackgroundColors,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
