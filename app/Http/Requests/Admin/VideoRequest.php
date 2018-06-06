<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class VideoRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required',
        ];

        return $rules;
    }
}
