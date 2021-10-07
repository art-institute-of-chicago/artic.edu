<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class ExhibitionRequest extends Request
{
    public function rulesForCreate()
    {
        $rules = [
            'title' => 'required',
        ];

        return $rules;
    }

    public function rulesForUpdate()
    {
        $rules = [
            'title' => 'required',
        ];

        return $rules;
    }
}
