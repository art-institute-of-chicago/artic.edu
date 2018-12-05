<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class ExhibitionPressRoomController extends ModuleController
{
    protected $moduleName = 'exhibitionPressRooms';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/press/exhibition-press-room' . '/' . request('exhibitionPressRoom') . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}
