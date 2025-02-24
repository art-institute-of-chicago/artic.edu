<?php

namespace App\Http\Controllers\Twill;

class ExhibitionPressRoomController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('exhibitionPressRooms');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function formData($request)
    {
        $baseUrl = config('app.url') . '/press/exhibition-press-room' . '/' . request('exhibitionPressRoom') . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
