<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class HourRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
            'valid_from' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'valid_from' => 'required'
        ];
    }
}
