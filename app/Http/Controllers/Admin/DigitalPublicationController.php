<?php

namespace App\Http\Controllers\Admin;

class DigitalPublicationController extends ModuleController
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
    ];

    protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalPublication') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/digital-publications/' . $item->id . '/';
        $heroBackgroundColors = collect([
            '#282829',
            '#422E22',
            '#284725',
            '#1E3F49',
            '#1C2454',
            '#35295A',
            '#711F2A',
            '#983820',
            '#E19E26',
        ])->mapWithKeys(fn ($hexColor) => [$hexColor => $hexColor]);

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
