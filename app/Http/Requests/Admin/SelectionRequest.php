<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class SelectionRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required'
        ];
    }
}
