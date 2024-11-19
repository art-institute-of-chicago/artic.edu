<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class MiradorRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
        ];
    }
}
