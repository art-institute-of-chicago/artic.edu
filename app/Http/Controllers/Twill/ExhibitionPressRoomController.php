<?php

namespace App\Http\Controllers\Admin;

class ExhibitionPressRoomController extends ModuleController
{
    protected $moduleName = 'exhibitionPressRooms';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/press/exhibition-press-room' . '/' . request('exhibitionPressRoom') . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
