<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class FeeCategoryRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
            'tooltip' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'tooltip' => 'required',
        ];
    }
}
