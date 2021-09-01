<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class HighlightRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }
}
