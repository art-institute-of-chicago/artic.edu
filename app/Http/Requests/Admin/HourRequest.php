<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class HourRequest extends Request
{
    public function rules()
    {
        $rules = [
            'opening_time' => 'required',
            'closing_time' => 'required'
        ];

        return $rules;
    }
}
