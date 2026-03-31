<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;
use App\Rules\InnerTextLength;

class VideoRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
            'list_description' => [new InnerTextLength(max: 255)],
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'list_description' => [new InnerTextLength(max: 255)],
        ];
    }
}
