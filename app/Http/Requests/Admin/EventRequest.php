<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class EventRequest extends Request
{
    public function rulesForCreate() {
        return [];
    }

    public function rulesForUpdate()
    {
        $rules = [
            'start_time' => 'required',
            'end_time'   => 'required',
        ];

        return $rules;
    }
}
