<?php

namespace App\Http\Controllers\Twill;

class DigitalPublicationController extends \App\Http\Controllers\Twill\ModuleController
{
    protected $moduleName = 'digitalPublications';
    protected $previewView = 'site.genericPage.show';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Is DSC stub?',
            'field' => 'is_dsc_stub',
            'sort' => true,
            'present' => true,
        ],
        'articles' => [
            'title' => 'Articles',
            'nested' => 'articles',
        ],
    ];

    protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalPublication') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/digital-publications/' . $item->id . '/';
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
