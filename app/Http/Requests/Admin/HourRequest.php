<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class HourRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
            'validFrom' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'validFrom' => 'required'
        ];
    }
}
